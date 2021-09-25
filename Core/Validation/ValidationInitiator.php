<?php

namespace Zed\Framework\Validation;

use Zed\Framework\Validation\Strategy\{EmailValidator, MaximumValidator, MinimumValidator, NumericValidator, RequiredValidator, StringValidator, UniqueValidator};
use Zed\Framework\Exception\ValidationException;
use Zed\Framework\Validation;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class ValidationInitiator
{
    /**
     * Validation error(s).
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $errors;

    /**
     * Validation rules.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $validationRules;

    /**
     * Request inputs.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $requestInputs;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param array $validationRules
     * @param array $requestInputs
     * 
     * @return void
     */
    public function __construct(array $validationRules, array $requestInputs)
    {
        $this->validationRules = $validationRules;
        $this->requestInputs = $requestInputs;
    }

    /**
     * Initiate validating request parameters.
     * 
     * @since 1.0.1
     * 
     * @throws Exception if validation rule is not defined.
     * @throws ValidationException if validation has error(s).
     * 
     * @return void
     */
    public function initiate(): void
    {
        foreach ($this->validationRules as $attribute => $rules) {
            foreach (explode('|', $rules) as $rule) {
                $ruleName = explode(':', $rule)[0] ?? $rule;

                $validationInformation = ['attribute' => $attribute];
                switch ($ruleName) {
                    case Validation::RULE_REQUIRED:
                        $strategy = new RequiredValidator;
                        break;
                    case Validation::RULE_MAX:
                        $validationInformation['Rule'] = $rule;
                        $strategy = new MaximumValidator;
                        break;
                    case Validation::RULE_MIN:
                        $validationInformation['Rule'] = $rule;
                        $strategy = new MinimumValidator;
                        break;
                    case Validation::RULE_NUMERIC:
                        $strategy = new NumericValidator;
                        break;
                    case Validation::RULE_UNIQUE:
                        $validationInformation['Rule'] = $rule;
                        $strategy = new UniqueValidator;
                        break;
                    case Validation::RULE_STRING:
                        $strategy = new StringValidator;
                        break;
                    case Validation::RULE_EMAIL:
                        $strategy = new EmailValidator;
                        break;
                    default:
                        throw new Exception('Undefined validation rule.');
                }

                $error = $strategy
                    ->setParams($this->requestInputs)
                    ->validate($validationInformation)
                    ->getError()
                ;

                if ($error)
                    $this->errors[$attribute][] = $error;
            }
        }

        if (! empty($this->errors))
            throw new ValidationException($this->errors);
    }
}
