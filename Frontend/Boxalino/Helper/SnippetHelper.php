<?php

class Shopware_Plugins_Frontend_Boxalino_Helper_SnippetHelper {

    protected $namespace;
    
    protected $shopID;
    
    protected $localeID;
    
    protected $snippets;

    function __construct($namespace, $shopID = null, $localeID = null)
    {
        $this->namespace    = $namespace;
        $this->shopID       = $shopID;
        $this->localeID     = $localeID;
        $this->snippets     = $this->getAllSnippets();
    }

    public function add($name, $value) {
        if (isset($this->snippets[$name]) && $this->snippets[$name]['value'] == $value) {
            return;
        }
        $sql = "INSERT INTO s_core_snippets 
                (namespace, shopID, localeID, name, value)
                VALUES 
                (?, ?, ?, ?, ?)";

        Shopware()->Db()->query($sql, array($this->namespace, $this->shopID, $this->localeID, $name, $value));
    }

    public static function removeAll($namespace) {
        $sql = "DELETE FROM s_core_snippets 
                WHERE namespace=?";

        Shopware()->Db()->query($sql, array($namespace));
    }
    
    private function getAllSnippets() {
        $sql = "SELECT * FROM s_core_snippets 
                WHERE namespace=?";

        $result = Shopware()->Db()->query($sql, array($this->namespace))->fetchAll();
        $snippets = array();
        foreach ($result as $r) {
            $snippets[$r['name']] = $r;
        }
        return $snippets;
    }

}