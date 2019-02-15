<?php

namespace RTW\Classes;

/*
 * Class Pagination
 *
 * @author Luciano Charles de Souza
 * E-mail: souzacomprog@gmail.com
 * Github: https://github.com/LucianoCharlesdeSouza
 * YouTube: https://www.youtube.com/channel/UC2bpyhuQp3hWLb8rwb269ew?view_as=subscriber
 */

trait Pagination
{

    private $indexPage = 0,
            $links = '',
            $maxPage = 2,
            $maxLinks = 2,
            $places = [],
            $page = 'page',
            $query = '',
            $queryCount = null;

    /**
     * Método que recebe o valor máximo de registros por página
     * @param $max int
     * @throws Exception
     */
    public function maxPerPage($max)
    {
        if (!is_int($max) || !is_numeric($max)) {
            throw new Exception("Passe um valor inteiro para o máximo de registro por páginas!");
        }
        $this->maxPage = (int) $max;
    }

    /**
     * Método que recebe o nome do page
     * @param $namePage string
     * @throws Exception
     */
    public function page($namePage)
    {
        if (!is_string($namePage)) {
            throw new Exception("O nome do paginador deve ser tipo string!");
        }
        $this->page = (string) $namePage;
    }

    /**
     * Método que recebe o valor máximo de links visiveis a esquerda e direita
     * @param $maxlinks int
     * @throws Exception
     */
    public function maxLinks($maxlinks)
    {
        if (!is_int($maxlinks) || !is_numeric($maxlinks)) {
            throw new Exception("Passe um valor para o máximo de links!");
        }
        $this->maxLinks = (int) $maxlinks;
    }

    /**
     * Método que retorna
     * os itens para a paginação
     * @return array
     */
    public function paginate($where = null)
    {
        $Query = "SELECT * FROM {$this->table} {$where}";
        $this->getIndexPage();
        $this->query .= $Query . " LIMIT " . $this->indexPage . "," . $this->maxPage;
        return $this->fullSql($this->query, $this->places);
    }

    /**
     * Método que recebe uma string SQL para retornar
     * os itens para a paginação
     * @param $Query string
     * @return array
     */
    public function createPagination($Query)
    {
        $this->getIndexPage();
        $this->query .= $Query . " LIMIT " . $this->indexPage . "," . $this->maxPage;
        return $this->fullSql($this->query, $this->places);
    }

    /**
     * Método que recebe um array para usar como substitutos no Bind
     * @param array $placesValues
     */
    public function bindValues(array $placesValues)
    {
        $this->places = $placesValues;
    }

    /**
     * Método que gera os links de paginação
     * @return string
     */
    public function createLinks()
    {
        $this->pagingNumberExceeded();
        if ($this->totalRecords() > $this->maxPage) {
            $this->firstLink();
            $this->previousLink();
            $this->currentLink();
            $this->nextLink();
            $this->lastLink();
        }
        return $this->links;
    }

    /**
     * Método que recebe o valor atual da paginação
     * @return int|string
     */
    private function getPager()
    {
        $pager = filter_input(INPUT_GET, $this->page);
        return (isset($pager) ? (int) $pager : $pager . 1);
    }

    /**
     * Método que recebe objeto PDO mais o array Places,
     * gerando os Bind's
     * @param $stmt
     * @param null $Fields array
     */
    private function createBind($stmt, $Fields = null)
    {
        if ($Fields != null) {
            foreach ($Fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
    }

    /**
     * Método que recebe uma string SQL,
     * podendo ou não receber também um array para as substituições
     * no Bind
     * @param $Query string
     * @param array|null $Fields
     * @return array
     */
    private function fullSql($Query, array $Fields = null)
    {
        try {
            $sql = strtolower($Query);

            $update = (strpos($sql, "update") !== false) ? true : false;
            $delete = (strpos($sql, "delete") !== false) ? true : false;
            $insert = (strpos($sql, "insert") !== false) ? true : false;

            $stmt = $this->db->prepare($Query);
            $this->createBind($stmt, $Fields);
            $stmt->execute();

            if ($update) {
                return true;
            }

            if ($delete) {
                return true;
            }

            if ($insert) {
                return true;
            }

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll();
            }

            return false;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Método que retorna o número da página
     * @return int
     */
    private function getIndexPage()
    {
        if ((($this->maxPage * $this->getPager()) - $this->maxPage) > 0) {
            return $this->indexPage = (($this->maxPage * $this->getPager()) - $this->maxPage);
        }
        return $this->indexPage = 0;
    }

    /**
     * Método que retorna a quantidade de registros da consulta,
     * que é usada para auxiliar na lágica da paginação
     * @return mixed
     */
    private function totalRecords()
    {
        $newQuery = explode('from', strtolower($this->query));
        $this->queryCount = str_replace($this->query, "select count(*) as total from " . $newQuery[1], $this->query);
        $this->queryCount = substr($this->queryCount, 0, strpos($this->queryCount, "limit"));
        $db = database();

        $fetchMode = $db['fetch_mode'];
        return ($fetchMode == 5) ? $this->fullSql($this->queryCount, $this->places)[0]->total : $this->fullSql($this->queryCount, $this->places)[0]['total'];
    }

    /**
     * Método que retorna o total de páginas que terá a paginação
     * @return float
     */
    private function totalPages()
    {
        return ceil($this->totalRecords() / $this->maxPage);
    }

    /**
     * Método que fará o redirecionamento sempre para a última página,
     * caso o usuário passe uma valor não existente de forma manual na url
     */
    private function pagingNumberExceeded()
    {
        if (($this->getPager() > $this->totalPages() || $this->getPager() < 1) && $this->totalRecords() != 0) {
            header("Location: " . $this->ReturnPageValid($this->page) . "?" . $this->page . "=" . $this->totalPages());
        }
    }

    /**
     * Método que gera o html para o primeiro item da paginação
     */
    private function firstLink()
    {
        $this->links .= "<div class=\"col-sm-12 text-center\"><ul class=\"pagination\">";
        $first = "<li class=\"page-item\"><a class=\"page-link\" href = \"?" . $this->page . "=1\">&laquo;</a></li>";
        $this->links .= $first;
    }

    /**
     * Método que gera o html para o item anterior da paginação atual
     */
    private function previousLink()
    {
        for ($i = $this->getPager() - $this->maxLinks; $i <= $this->getPager() - 1; $i++) {
            if ($i >= 1) {
                $this->links .= "<li class=\"page-item\"><a class=\"page-link\" href=\"?" . $this->page . "=" . $i . "\">" . $i . "</a></li>";
            }
        }
    }

    /**
     * Método que gera o html para o item atual da paginação
     */
    private function currentLink()
    {
        $this->links .= "<li class=\"page-item active\"><a class=\"page-link\" href='#'>" . $this->getPager() . " <span class=\"sr-only\">(current)</span></a></li>";
    }

    /**
     * Método que gera o html para o próximo item da paginação atual
     */
    private function nextLink()
    {
        for ($i = $this->getPager() + 1; $i <= $this->getPager() + $this->maxLinks; $i++) {
            if ($i <= $this->totalPages()) {
                $this->links .= "<li class=\"page-item\"><a class=\"page-link\" href=\"?" . $this->page . "=" . $i . "\">" . $i . "</a></li>";
            }
        }
    }

    /**
     * Método que gera o html para o último item da paginação
     */
    private function lastLink()
    {
        $last = "<li class=\"page-item\"><a class=\"page-link\" href=\"?" . $this->page . "=" . $this->totalPages() . "\">&raquo;</a></li></ul></div>";
        $this->links .= $last;
    }

    /**
     * Método que retorna a url com o nome do page, porem sem o valor da paginação
     * @param $namePager
     * @return bool|string
     */
    private function ReturnPageValid($namePager)
    {
        $URL = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $url = "http://" . $URL . filter_input(INPUT_SERVER, 'REQUEST_URI');
        $https = filter_input(INPUT_SERVER, 'HTTPS');
        if (isset($https) && $https == 'on') {
            $url = "https://" . $URL . filter_input(INPUT_SERVER, 'REQUEST_URI');
        }
        return substr($url, 0, strpos($url, "?" . $namePager));
    }

}
