<?php

namespace RTW\Classes;

/**
 * Trait ValidationTrait

 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
trait ValidationTrait
{

    /**
     * Método que valida se o value do indice existe e se não esta vazio
     * @param $name
     * @param $val
     * @return bool
     */
    private function required($name, $val)
    {
        if (isset($val) && $val != '') {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['required'])) {
            $errorMsg = $this->messages_[$name]['required'];
        } else {
            $errorMsg = "O campo <b>{$name}</b> precisa ser preenchido.";
        }

        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

    /**
     * Método que valida se o value do indice possui a qtd minima de caracteres ou digitos
     * @param $name
     * @param $val
     * @param $qtd
     * @return bool
     */
    private function minValue($name, $val, $qtd)
    {
        if (strlen($val) >= $qtd) {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['min'])) {
            $errorMsg = $this->messages_[$name]['min'];
        } else {
            $errorMsg = "O campo <b>{$name}</b> precisa ter uma quantidade mínima de <b>{$qtd}</b> caracteres";
        }
        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

    /**
     * Método que valida se o value do indice possui a qtd maxima de caracteres ou digitos
     * @param $name
     * @param $val
     * @param $qtd
     * @return bool
     */
    private function maxValue($name, $val, $qtd)
    {
        if (strlen($val) <= $qtd) {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['max'])) {
            $errorMsg = $this->messages_[$name]['max'];
        } else {
            $errorMsg = "O campo <b>{$name}</b> pode ter no máximo <b>{$qtd}</b> caracteres";
        }
        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

    /**
     * Método que valida se o value do indice sob validação
     * é exclusivo em uma determinada tabela do banco de dados.
     * @param $name
     * @param $val
     * @param $table
     * @param $col
     * @param $val2
     * @return bool
     */
    private function unique($name, $val, $table, $col, $val2)
    {
        if ($col != '' && $val2 != '') {
            $col = " AND {$col} <> :id ";
        }

        $conn = DB::getConn();
        $sql = "SELECT {$name} FROM {$table} WHERE {$name} = :val {$col}";

        $query = $conn->prepare($sql);
        $query->bindValue(':val', $val);

        if ($col != '' && $val2 != '') {
            $query->bindValue(':id', $val2);
        }

        $query->execute();
        $total = $query->rowCount();

        if ($total == 0) {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['unique'])) {
            $errorMsg = $this->messages_[$name]['unique'];
        } else {
            $errorMsg = "O <b>{$name}</b> já tem o valor <b>{$val}</b> cadastrado. Informe outro valor.";
        }
        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

    /**
     * Método que valida se o value do indice não esta vazio
     * e se esta com formato de email válido
     * @param $name
     * @param $val
     * @return bool
     */
    private function email($name, $val)
    {
        if (empty($val) || filter_var($val, FILTER_VALIDATE_EMAIL) == true) {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['email'])) {
            $errorMsg = $this->messages_[$name]['email'];
        } else {
            $errorMsg = "O campo <b>{$name}</b> é um e-mail inválido.";
        }
        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

    /**
     * Método que valida se o value do indice tem uma string como valor
     * @param $name
     * @param $val
     * @return bool
     */
    private function string($name, $val)
    {
        $c =  ctype_alpha($val);
        if (empty($val) || $c == true) {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['string'])) {
            $errorMsg = $this->messages_[$name]['string'];
        } else {
            $errorMsg = "O campo <b>{$name}</b> não é uma string válida.";
        }
        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

    /**
     * Método que valida se o value do  indice é um inteiro
     * @param $name
     * @param $val
     * @return bool
     */
    private function int($name, $val)
    {
        if(empty($val) ||  filter_var($val, FILTER_VALIDATE_INT) == true) {
            return true;
        }

        $this->error = true;

        if (isset($this->messages_[$name]['int'])) {
            $errorMsg = $this->messages_[$name]['int'];
        } else {
            $errorMsg = "O campo <b>{$name}</b> não é um inteiro válido.";
        }
        $this->msgsErrors[] = str_replace(':message', $errorMsg, $this->formatMsgs);
    }

}
