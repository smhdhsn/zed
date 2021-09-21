<?php

namespace Zed\Framework;

use Zed\Framework\Traits\Validation\{RequiredValidation, MaximumValidation, MinimumValidation, NumericValidation, StringValidation, UniqueValidation, EmailValidation};
use Zed\Framework\{Controller, Database, Response};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Validation
{
    use RequiredValidation, MaximumValidation, MinimumValidation, NumericValidation, StringValidation, UniqueValidation, EmailValidation;

    /**
     * Validation error(s).
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $errors = [];

    /**
     * Database connection.
     * 
     * @since 1.0.1
     * 
     * @var object
     */
    private ?object $connection = null;

    /**
     * Available rules.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST RULE_REQUIRED = 'required';
    CONST RULE_NUMERIC = 'numeric';
    CONST RULE_UNIQUE = 'unique';
    CONST RULE_STRING = 'string';
    CONST RULE_EMAIL = 'email';
    CONST RULE_MAX = 'max';
    CONST RULE_MIN = 'min';

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = Application::$database->getConnection();
    }

    /**
     * Validate request prameter(s).
     * 
     * @since 1.0.0
     * 
     * @param array $validationRules
     * 
     * @return object
     */
    public function validate(array $validationRules): object
    {
        foreach ($validationRules as $requestAttribute => $rules) {
            foreach (explode('|', $rules) as $rule) {
                
                $ruleName = explode(':', $rule)[0] ?? $rule;

                switch ($ruleName) {
                    case self::RULE_MAX:
                        $this->validateMaximum($requestAttribute, $rule);
                    break;
                    case self::RULE_MIN:
                        $this->validateMinimum($requestAttribute, $rule);
                    break;
                    case self::RULE_UNIQUE:
                        $this->validateUnique($requestAttribute, $rule);
                    break;
                    case self::RULE_REQUIRED:
                        $this->validateRequired($requestAttribute);
                    break;
                    case self::RULE_NUMERIC:
                        $this->validateNumeric($requestAttribute);
                    break;
                    case self::RULE_STRING:
                        $this->validateString($requestAttribute);
                    break;
                    case self::RULE_EMAIL:
                        $this->validateEmail($requestAttribute);
                    break;
                }
            }
        }
        
        return empty($this->errors)
        ? $this
        : $this->abort();
    }

    /**
     * Record validation error(s).
     * 
     * @since 1.0.0
     * 
     * @param string $rule
     * @param string $attribute
     * @param array|null $params
     * 
     * @return void
     */
    private function addError(string $rule, string $attribute, ?array $params = []): void
    {
        $message = $this->messages()[$rule];

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }
    
    /**
     * Validation error messages.
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function messages(): array
    {
        return [
            self::RULE_MAX => 'Maximum length of this field must be less than {max} characters.',
            self::RULE_MIN => 'Minimum length of this field must be more than {min} characters.',
            self::RULE_UNIQUE => 'Given {unique} already exists in database.',
            self::RULE_EMAIL => 'This field must be valid email address.',
            self::RULE_NUMERIC => 'This field must be numeric.',
            self::RULE_STRING => 'This field must be string.',
            self::RULE_REQUIRED => 'This field is required.',
        ];
    }

    /**
     * Splits rule syntax into parts that can be used by validation section.
     * 
     * @since 1.0.0
     * 
     * @param string $rawRule
     * 
     * @return array
     */
    private function getParts(string $rawRule): array
    {
        $rule = explode(':', $rawRule);

        return [
            $rule[0] => strpos($rule[1], ',') ? explode(',', $rule[1]) : $rule[1]
        ];
    }

    /**
     * In case validation has failure(s).
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function abort(): void
    {
        die(
            (new Controller)->error(
                Response::ERROR,
                $this->errors,
                Response::HTTP_MISDIRECTED_REQUEST
            )
        );
    }
}
