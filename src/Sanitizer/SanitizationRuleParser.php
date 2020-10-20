<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Backyard sanitizer helper.
 *
 * @package   backyard-framwork
 * @author    Sematico LTD <hello@sematico.com>
 * @copyright 2020 Sematico LTD
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://sematico.com
 */

namespace Backyard\Sanitizer;

use Backyard\Utils\Str;
use Closure;
use Backyard\Contracts\ValidationRuleInterface as RuleContract;
use Backyard\Utils\Arr;

/**
 * Parse sanitization rules.
 */
class SanitizationRuleParser {

	/**
	 * The data being validated.
	 *
	 * @var array
	 */
	public $data;

	/**
	 * The implicit attributes.
	 *
	 * @var array
	 */
	public $implicitAttributes = [];

	/**
	 * Create a new validation rule parser.
	 *
	 * @param  array $data
	 * @return void
	 */
	public function __construct( array $data ) {
		$this->data = $data;
	}

	/**
	 * Parse the human-friendly rules into a full rules array for the validator.
	 *
	 * @param  array $rules
	 * @return \stdClass
	 */
	public function explode( $rules ) {
		$this->implicitAttributes = [];

		$rules = $this->explodeRules( $rules );

		return (object) [
			'rules'              => $rules,
			'implicitAttributes' => $this->implicitAttributes,
		];
	}

	/**
	 * Explode the rules into an array of explicit rules.
	 *
	 * @param  array $rules
	 * @return array
	 */
	protected function explodeRules( $rules ) {
		foreach ( $rules as $key => $rule ) {
			if ( Str::contains( $key, '*' ) ) {
				$rules = $this->explodeWildcardRules( $rules, $key, [ $rule ] );

				unset( $rules[ $key ] );
			} else {
				$rules[ $key ] = $this->explodeExplicitRule( $rule );
			}
		}

		return $rules;
	}

	/**
	 * Explode the explicit rule into an array if necessary.
	 *
	 * @param  mixed $rule
	 * @return array
	 */
	protected function explodeExplicitRule( $rule ) {
		if ( is_string( $rule ) ) {
			return explode( '|', $rule );
		} elseif ( is_object( $rule ) ) {
			return [ $this->prepareRule( $rule ) ];
		}

		return array_map( [ $this, 'prepareRule' ], $rule );
	}

	/**
	 * Prepare the given rule for the sanitizer.
	 *
	 * @param  mixed $rule
	 * @return mixed
	 */
	protected function prepareRule( $rule ) {
		if ( $rule instanceof Closure ) {
			$rule = new ClosureSanitizationRule( $rule );
		}

		if ( ! is_object( $rule ) || $rule instanceof RuleContract ) {
			return $rule;
		}

		return (string) $rule;
	}

	/**
	 * Define a set of rules that apply to each element in an array attribute.
	 *
	 * @param  array        $results
	 * @param  string       $attribute
	 * @param  string|array $rules
	 * @return array
	 */
	protected function explodeWildcardRules( $results, $attribute, $rules ) {
		$pattern = str_replace( '\*', '[^\.]*', preg_quote( $attribute ) );

		$data = SanitizationData::initializeAndGatherData( $attribute, $this->data );

		foreach ( $data as $key => $value ) {
			if ( Str::startsWith( $key, $attribute ) || (bool) preg_match( '/^' . $pattern . '\z/', $key ) ) {
				foreach ( (array) $rules as $rule ) {
					$this->implicitAttributes[ $attribute ][] = $key;

					$results = $this->mergeRules( $results, $key, $rule );
				}
			}
		}

		return $results;
	}

	/**
	 * Merge additional rules into a given attribute(s).
	 *
	 * @param  array        $results
	 * @param  string|array $attribute
	 * @param  string|array $rules
	 * @return array
	 */
	public function mergeRules( $results, $attribute, $rules = [] ) {
		if ( is_array( $attribute ) ) {
			foreach ( (array) $attribute as $innerAttribute => $innerRules ) {
				$results = $this->mergeRulesForAttribute( $results, $innerAttribute, $innerRules );
			}

			return $results;
		}

		return $this->mergeRulesForAttribute(
			$results,
			$attribute,
			$rules
		);
	}

	/**
	 * Merge additional rules into a given attribute.
	 *
	 * @param  array        $results
	 * @param  string       $attribute
	 * @param  string|array $rules
	 * @return array
	 */
	protected function mergeRulesForAttribute( $results, $attribute, $rules ) {

		$toMerge = $this->explodeRules( [ $rules ] );

		$merge = reset( $toMerge );

		$results[ $attribute ] = array_merge(
			isset( $results[ $attribute ] ) ? $this->explodeExplicitRule( $results[ $attribute ] ) : [],
			$merge
		);

		return $results;
	}

	/**
	 * Extract the rule name and parameters from a rule.
	 *
	 * @param  array|string $rules
	 * @return array
	 */
	public static function parse( $rules ) {
		if ( $rules instanceof RuleContract ) {
			return [ $rules, [] ];
		}

		if ( is_array( $rules ) ) {
			$rules = static::parseArrayRule( $rules );
		} else {
			$rules = static::parseStringRule( $rules );
		}

		$rules[0] = static::normalizeRule( $rules[0] );

		return $rules;
	}

	/**
	 * Parse an array based rule.
	 *
	 * @param  array $rules
	 * @return array
	 */
	protected static function parseArrayRule( array $rules ) {
		return [ Str::studly( trim( Arr::get( $rules, 0 ) ) ), array_slice( $rules, 1 ) ];
	}

	/**
	 * Parse a string based rule.
	 *
	 * @param  string $rules
	 * @return array
	 */
	protected static function parseStringRule( $rules ) {
		$parameters = [];

		// The format for specifying validation rules and parameters follows an
		// easy {rule}:{parameters} formatting convention. For instance the
		// rule "Max:3" states that the value may only be three letters.
		if ( strpos( $rules, ':' ) !== false ) {
			[$rules, $parameter] = explode( ':', $rules, 2 );

			$parameters = static::parseParameters( $rules, $parameter );
		}

		return [ Str::studly( trim( $rules ) ), $parameters ];
	}

	/**
	 * Parse a parameter list.
	 *
	 * @param  string $rule
	 * @param  string $parameter
	 * @return array
	 */
	protected static function parseParameters( $rule, $parameter ) {
		$rule = strtolower( $rule );

		if ( in_array( $rule, [ 'regex', 'not_regex', 'notregex' ], true ) ) {
			return [ $parameter ];
		}

		return str_getcsv( $parameter );
	}

	/**
	 * Normalizes a rule so that we can accept short types.
	 *
	 * @param  string $rule
	 * @return string
	 */
	protected static function normalizeRule( $rule ) {
		switch ( $rule ) {
			case 'Int':
				return 'Integer';
			case 'Bool':
				return 'Boolean';
			default:
				return $rule;
		}
	}

}
