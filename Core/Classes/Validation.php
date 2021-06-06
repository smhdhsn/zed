<?php

namespace Core\Classes;

use Core\Classes\{BaseController, Response};
use Core\Traits\Validation\{Required, Maximum, Minimum, Email};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Validation
{
    use Required, Maximum, Minimum, Email;

    /**
     * Validation Errors.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $errors = [];

    /**
     * Available Rules.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST RULE_REQUIRED = 'required';
    CONST RULE_EMAIL = 'email';
    CONST RULE_MAX = 'max';
    CONST RULE_MIN = 'min';

    /**
     * Validating Request Prameters.
     * 
     * @since 1.0.0
     * 
     * @param array $validationRules
     * 
     * @return object
     */
    public function validate(array $validationRules): object
    {
        foreach ($validationRules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $ruleName = is_array($rule) ? $rule[0] : $rule;

                switch ($ruleName) {
                    case self::RULE_MAX:
                        $this->validateMaximum($attribute, $rule);
                    break;
                    case self::RULE_MIN:
                        $this->validateMinimum($attribute, $rule);
                    break;
                    case self::RULE_REQUIRED:
                        $this->validateRequired($attribute);
                    break;
                    case self::RULE_EMAIL:
                        $this->validateEmail($attribute);
                    break;
                }
            }
        }
        
        return empty($this->errors)
        ? $this
        : $this->abort();
    }

    /**
     * Recording Validation Errors.
     * 
     * @since 1.0.0
     * 
     * @param array|null $params
     * @param string $attribute
     * @param string $rule
     * 
     * @return void
     */
    private function addError(string $attribute, string $rule, ?array $params = [])
    {
        $message = $this->messages()[$rule];

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }
    
    /**
     * Validation Error Messages.
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private function messages(): array
    {
        return [
            self::RULE_REQUIRED => 'This Field Is Required.',
            self::RULE_EMAIL => 'This Field Must Be Valid Email Address.',
            self::RULE_MIN => 'Minimum Length Of This Field Must Be Less Than {min} Characters.',
            self::RULE_MAX => 'Maximum Length Of This Field Must Be More Than {max} Characters.',
        ];
    }

    /**
     * In Case The Validation Has Errors.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function abort(): void
    {
        die(
            (new BaseController)->error(
                Response::ERROR,
                $this->errors,
                Response::HTTP_MISDIRECTED_REQUEST
            )
        );
    }
}
