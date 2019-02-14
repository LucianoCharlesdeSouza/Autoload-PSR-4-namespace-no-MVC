<?php

namespace RTW\Classes;

/**
 * Class Request

 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */
class Request
{

    private $requestType;

    /**
     * Aplica o tipo de requisição ao atributo $requestType
     * Request constructor.
     */
    public function __construct()
    {
        $this->requestType = ($_SERVER['REQUEST_METHOD'] == 'POST') ? $_POST : $_GET;
    }

    /**
     * Método que retorna um array ja higienizados com os indices e valores
     * submetidos pelo método POST
     * @return array|mixed
     */
    public function postAll()
    {
        $array = $this->stripTags(filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES));
        $array = array_map('trim', $array);

        return $array;
    }

    /**
     * Método que retorna um array ja higienizados com os indices e valores
     * submetidos pelo método GET
     * @return array|mixed
     */
    public function getAll()
    {
        $array = $this->stripTags(filter_input_array(INPUT_GET, FILTER_SANITIZE_MAGIC_QUOTES));
        $array = array_map('trim', $array);

        return $array;
    }

    /**
     * Método que recebe um name de um input pelo método POST
     * mais um tipo de filtro a ser aplicado e
     * retorna uma string ja higienizada
     * @param $field
     * @param int $type
     * @return bool|string
     */
    public function post($field, $type = FILTER_DEFAULT)
    {

        if (filter_input(INPUT_POST, $field) != null) {

            return addslashes(trim(filter_input(INPUT_POST, $field, $type)));
        }
        return false;
    }

    /**
     * Método que recebe um name de um input pelo método GET
     * mais um tipo de filtro a ser aplicado e
     * retorna uma string ja higienizada
     * @param $field
     * @param int $type
     * @return bool|string
     */
    public function get($field, $type = FILTER_DEFAULT)
    {

        if (filter_input(INPUT_POST, $field) != null) {

            return addslashes(trim(filter_input(INPUT_GET, $field, $type)));
        }
        return false;
    }

    /**
     * Método que verifica se um $field esta vazio e
     * retorna true ou false
     * @param $field
     * @return bool
     */
    public function isEmpty($field)
    {
        return (empty($field)) ? true : false;
    }

    /**
     * Método que retorna um array ja higienizados com os indices e valores
     * Usados em inputs cujo name é um array (<input type="checkbox" name="cor[]"/>)
     * @param type $fieldArray
     * @return array
     */
    public function inputArray($fieldArray)
    {

        if (key_exists($fieldArray, $this->requestType)) {
            foreach ($this->requestType[$fieldArray] as $field => $value) {
                $data[$field] = addslashes(trim($this->stripTags($value)));
            }

            return $data;
        }

        return false;
    }

    /**
     * Método que retorna um array ja higienizados com os indices e valores
     * @return array
     */
    public function all()
    {
        foreach ($this->requestType as $field => $value) {
            $data[$field] = addslashes(trim($this->stripTags($value)));
        }

        return $data;
    }

    /**
     * Método que retorna um array com indices a serem retornados ja higienizados
     * @param array $fields
     * @return mixed
     */
    public function only(array $fields)
    {
        foreach ($fields as $field) {
            $data[$field] = addslashes(trim($this->stripTags($this->requestType[$field])));
        }

        return $data;
    }

    /**
     * Método que recebe um array com indices que ficarão de fora
     * do retorno ja higienizados
     * @param array $fields
     * @return array
     */
    public function except(array $fields)
    {
        $data = $this->all();

        foreach ($fields as $field) {
            if (isset($data[$field]))
                unset($data[$field]);
        }

        return $data;
    }

    /**
     * Método que recebe uma string com o name do input file
     * @param $field
     * @return mixed
     */
    public function file($field)
    {
        return isset($_FILES[$field]) ? $_FILES[$field] : false;
    }

    /**
     * Método que recebe uma string com o name do inpout file e
     * o retorna caso exista e não esteja vazio
     * @param $field
     * @return bool
     */
    public function hasFile($field)
    {
        return (isset($_FILES[$field]) && $_FILES[$field]['name'] != '' );
    }

    /**
     * Método que pode receber uma string para completar a url de redirecionamento
     * @param null $to
     */
    public function redirect($to = null)
    {
        header("Location: " . base_url($to));
        exit();
    }

    /**
     * Método que pode receber uma string  e um int simbolizando o tempo
     * para completar a url de redirecionamento
     * @param null $to
     * @param int $time
     */
    public function redirectAfter($to = null, $time = 3)
    {
        header("Refresh: " . $time . ";url=" . base_url($to));
        exit();
    }

    /**
     * Método recebe um array de indices e valores para
     * armazenar na sessão
     * @param array $data
     */
    public function withInput(array $data)
    {
        Session::withInput($data);
    }

    /**
     * Método que compara a autenticidade do token da aplicação
     * podendo receber uma string como complemento para a url de redirecionamento
     * @param string $redirectTo
     */
    public function csrfValid($redirectTo = "/notFound/unauthorized")
    {

        if (Session::get('_token') !== $this->post('_token')) {
            if (Session::has('ajaxForm')) {
                Session::destroy('ajaxForm');
                $data['redirect'] = Alert::AjaxRedirect($redirectTo, 1000);
                echo json_encode($data);
                exit();
            }
            return redirect($redirectTo);
        }
    }

    /**
     * Método que higieniza as entradas de dados dos metodos desta classe
     * @param $text
     * @param string $tags
     * @param bool $invert
     * @return mixed
     */
    public function stripTags($text, $tags = '', $invert = FALSE)
    {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if (is_array($tags) AND count($tags) > 0) {
            if ($invert == FALSE) {
                return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            } else {
                return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
            }
        } elseif ($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    private function inputType($request)
    {
        return ($request == $_POST) ? INPUT_POST : INPUT_GET;
    }

}
