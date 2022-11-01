<?php
header("Content-type:application/json");
class API extends Dbase
{
    public function getCountries()
    {
        /*
        * page(optional)
        * limit(optional)
        * search(optional)
        */
        extract($_REQUEST);
        $page = !empty($page) ? $page : 1;
        $limit = !empty($limit) ? $limit : 10;
        $search = !empty($search) ? $search : '';
        $records = null;
        $totalPage = null;
        $query = "SELECT `id`, `continent_code`, `currency_code`, `iso2_code`, `iso3_code`, `iso_numeric_code`, `fips_code`, `calling_code`, `common_name`, `official_name`, `endonym`, `demonym` FROM `countries`";
        $res = $this->query($query);
        $total = $this->num_rows($res);
        if (!empty($total)) {
            $totalPage = ceil($total / $limit);
            $totalPage = ($totalPage > 0) ? $totalPage : 1;
            $page = ($page > $totalPage) ? $totalPage : $page;
            $start = $limit * ($page - 1);
            if (!empty($search)) {
                $query .= " where LOWER(common_name) '%" . $search . "%'";
            }
            $query .= " limit $start,$limit";
            $res = $this->query($query);
            while ($row = $this->fetch_array_assoc($res)) {
                $records[] = $row;
            }
        }
        $data['total'] = $total;
        $data['totalPage'] = $totalPage;
        $data['cutrrentPage'] = $page;
        $data['records'] = $records;
        echo json_encode($data);
    }
    public function getCurrncies()
    {
        /*
        * page(optional)
        * limit(optional)
        * search(optional)
        */
        extract($_REQUEST);
        $page = !empty($page) ? $page : 1;
        $limit = !empty($limit) ? $limit : 10;
        $search = !empty($search) ? $search : '';
        $records = null;
        $totalPage = null;
        $query = "SELECT `id`, `iso_code`, `iso_numeric_code`, `common_name`, `official_name`, `symbol` FROM `currencies`";
        $res = $this->query($query);
        $total = $this->num_rows($res);
        if (!empty($total)) {
            $totalPage = ceil($total / $limit);
            $totalPage = ($totalPage > 0) ? $totalPage : 1;
            $page = ($page > $totalPage) ? $totalPage : $page;
            $start = $limit * ($page - 1);
            if (!empty($search)) {
                $query .= " where LOWER(common_name) '%" . $search . "%'";
            }
            $query .= " limit $start,$limit";
            $res = $this->query($query);
            while ($row = $this->fetch_array_assoc($res)) {
                $records[] = $row;
            }
        }
        $data['total'] = $total;
        $data['totalPage'] = $totalPage;
        $data['cutrrentPage'] = $page;
        $data['records'] = $records;
        echo json_encode($data);
    }
}
