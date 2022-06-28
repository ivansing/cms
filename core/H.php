<?php 
namespace Core;

class H {

    public static function dnd($data=[], $die = true){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        if($die) {
            die;
        }
    }

    // If it matches the link of the menu item
    // and hightlight that class as active link
    public static function isCurrentPage($page) {
        global $currentPage;
        if(!empty($page) && strpos($page, ':id') > -1) {
            $test = str_replace(":id", "", $page);
            return strpos($currentPage, $page) > -1;
        }
        return $page == $currentPage;
    }

    // Build a string of the class and then concatenate active class
    public static function activeClass($page, $class= '') {
        $active = self::isCurrentPage($page);
        $class = $active? $class . " active" : $class;
        return $class;
    }

    // Control nav items dropdown in main menu 
    public static function navItem($link, $label, $isDropdownItem = false){
        $active = self::isCurrentPage($link);
        $class = self::activeClass($link, 'nav-item');
        $linkClass = $isDropdownItem? 'dropdown-item' : 'nav-link';
        $linkClass .= $active && $isDropdownItem? " active" : "";
        $link = ROOT . $link;
        $html = "<li class=\"{$class}\">";
        $html .= "<a class=\{$linkClass}\" href=\"{$link}\" >{$label}</a>";
        $html .= "</li>";
        return $html;
    }
    
}