<?php

namespace RTW\Classes;

/**
 * Class Validation

 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Validation
{

    use ValidationTrait;

    protected $error = false;
    protected $msgsErrors = [];
    protected $formatMsgs = '<p>:message</p>';
    protected $messages_;
    protected $dataForm;

    /**
     * Método que recebe um array de regras e outro array de dados a serem validados,
     * podendo receber um array de mensagens personalizadas
     * @param array $rules
     * @param array $data
     * @param string $messages
     */
    public function validate(array $rules, array $data, $messages = '')
    {
        $this->messages_ = $messages;
        $this->dataForm = $data;
        foreach ($rules as $name => $rule) {
            $val = $data[$name];

            $rulesV = explode('|', $rule);
            foreach ($rulesV as $ruleV) {
                $this->validRule($ruleV, $name, $val);
            }
        }
    }

    /**
     * Método que valida as regras passadas no array $rules
     * @param $rule
     * @param $name
     * @param $val
     */
    private function validRule($rule, $name, $val)
    {
        $rule = explode(':', $rule);
        switch ($rule[0]) {
            case 'required':
                $this->required($name, $val);
                break;
            case 'email':
                $this->email($name, $val);
                break;
            case 'min':
                $this->minValue($name, $val, $rule[1]);
                break;
            case 'max':
                $this->maxValue($name, $val, $rule[1]);
                break;
            case 'unique':
                $unique = explode(',', $rule[1]);
                $table = $unique[0];
                $col = (isset($unique[1])) ? $unique[1] : '';
                $val2 = (isset($unique[2])) ? $unique[2] : '';
                $this->unique($name, $val, $table, $col, $val2);
                break;
            case 'int':
                $this->int($name, $val);
                break;
            case 'string':
                $this->string($name, $val);
                break;
        }
    }

    /**
     * Método que retorna true caso haja erro na validação
     * @return bool
     */
    public function hasError()
    {
        return $this->error;
    }

    /**
     * Método que retorna uma ou um array de mensagens da validação
     * @param null $all
     * @return mixed|string
     */
    public function messages($all = null)
    {
        $msg = '';
        if (count($this->msgsErrors) > 0 && $all === 'all') {
            foreach ($this->msgsErrors as $erros) {
                $msg .= $erros;
            }
            return $msg;
        }
        return $this->msgsErrors[0];
    }

    /**
     * Método que formata a saída das mensagens de validação
     * @param $format
     */
    private function formatMsgs($format)
    {
        $this->formatMsgs = $format;
    }

    /**
     * Método que retorna os dados ja validados
     * @return mixed
     */
    public function getData()
    {
        return $this->dataForm;
    }

}
