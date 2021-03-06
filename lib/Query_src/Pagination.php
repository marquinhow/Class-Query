<?php
//namespace to organize
namespace Query_src;

/**
 *
 * Class query - Pagination
 * @author Bruno Ribeiro <bruno.espertinho@gmail.com>
 * 
 * @version 1.4
 * @access public
 * @package Language
 * */
class Pagination extends Language {

    /**
     * Set this variable to false if you don't using tag <li>
     * 
     * @access public
     * @var Boolean 
     */
    var $li = false;

    /**
     * Set this variable to false if you don't want the pagination button after
     * 
     * @access public
     * @var Boolean 
     */
    var $after = true;

    /**
     * Set this variable to false if you don't want the pagination button before 
     * 
     * @access public
     * @var Boolean 
     */
    var $before = true;

    /**
     * Set this variable to true if you don't want the button before and after receive text messages.
     * Set this variable to false if you want show symbols.
     * 
     * @access public
     * @var Boolean 
     */
    var $message = true;

    /**
     * Set this variable to true if  you don't want inserts the symbol, remember to leave $message as false
     * 
     * @see $message
     * @access public
     * @var mixed 
     */
    var $message_before = false;

    /**
     * Message after buttom
     * if false symbol inserts the symbol, remember to leave $message as false
     * 
     * @access public
     * @var mixed 
     */
    var $message_after = false;

    /**
     * Class name for element active, use NULL if you want not put nothing
     * 
     * @access public
     * @var String 
     */
    var $class_active = NULL;

    /**
     * Class name for element inactive, use NULL if you want not put nothing
     * @var String 
     */
    var $class_inactive = NULL;

    /**
     * Class name for element before, use NULL if you want not put nothing
     * 
     * @access public
     * @var String 
     */
    var $class_before = NULL;

    /**
     * Class name for element after, use NULL if you want not put nothing
     * 
     * @access public
     * @var String 
     */
    var $class_after = NULL;

    /**
     * Set this variable to false if  you don't want show page numbers.
     * 
     * @access public
     * @var boolean 
     */
    var $pagination_show_numbering = true;

    public function get_page() {
        return $this->page;
    }

    public function get_pages() {
        return $this->pages;
    }

    public function get_perpage() {
        return $this->perpage;
    }

    public function get_total() {
        return $this->total;
    }

    /**
     * check to see if the parameter is equal to the selected mark as if the class as active
     * @access private
     * @param String $value Asset value of the pagination loop function
     * @param Integer $param Page parameter
     * @return string
     */
    private function verify_current($value, $param) {
        switch (true) {
            case (isset($this->class_active, $this->class_inative)):
                if ($value == $param) {
                    $result = ' class="' . $this->class_active . '"';
                } else {
                    $result = ' class="' . $this->class_inative . '"';
                }
                break;
            case (isset($this->class_active)):
                if ($value == $param) {
                    $result = ' class="' . $this->class_active . '"';
                }else{
                    $result = false;
                }
                break;
            case (isset($this->class_inative)):
                if ($value == $param) {
                    $result = ' class="' . $this->class_inative . '"';
                }else{
                    $result = false;
                }
                break;
            default:
                $result = NULL;
                break;
        }
        return $result;
    }

    /**
     * checks if the first page if not showing "Previous" and linked up with - 1
     * @access private
     * @param String $URL Full URL to the point of parameter pages
     * @param Iteger $value Asset value of the pagination loop function
     * @return string
     */
    function make_button_before($URL, $value) {
        $return = $value - 1;
        $class_last = isset($this->class_after) ? ' class="' . $this->class_before . '"' : NULL;
        if ($value > 1) {
            // check message
            if ($this->message) {
                $msg = $this->PAGINATION_TEXT_BEFORE;
            } else {
                $msg = !$this->message_before ? '&#171;' : $this->message_before;
            }
            // check li tag
            if ($this->li) {
                $result = '<li' . $class_last . '><a href="' . $URL . $return . '"> ' . $msg . ' </a></li>';
            } else {
                $result = '<a' . $class_last . ' href="' . $URL . $return . '"> ' . $msg . ' </a>';
            }
        }
        return isset($result) ? $result : false;
    }

    /**
     * checks if it is the last page if it does not show "Next" and linked up with + 1
     * added rules configuration class
     * @access private
     * @param String $URL Full URL to the point of parameter pages
     * @param $value Value of the asset page for pagination
     * @param $total Asset value of the pagination loop function
     * @return String
     */
    function make_button_after($URL, $value, $total) {
        $return = $value + 1;
        $class_before = isset($this->class_after) ? ' class="' . $this->class_after . '"' : NULL;
        if ($value < $total) {
            // check message
            if ($this->message) {
                $msg = $this->PAGINATION_TEXT_AFTER;
            } else {
                $msg = $this->message_after == false ? '&#187;' : $this->message_after;
            }
            // check li tag
            if ($this->li) {
                $result = '<li' . $class_before . '><a href="' . $URL . $return . '"> ' . $msg . ' </a></li>';
            } else {
                $result = '<a' . $class_before . ' href="' . $URL . $return . '"> ' . $msg . ' </a>';
            }
        }
        return isset($result) ? $result : false;
    }

    /**
     * checks whether the page border is greater than or equal to paramentro pages
     * this function is not to show the page if the set limit is less
     * @access private
     * @param String $URL Full URL to the point of parameter pages
     * @return Object
     * */
    private function verify_limit($page_param) {
        return ($this->get_pages() >= $page_param) ? true : false;
    }

    /**
     * create a loop with the numbering and put the link
     * @access private
     * @param String $URL Full URL to the point of parameter pages
     * @param Integer $page_param ID of the page
     * @return Object
     */
    private function loop($URL, $page_param) {
        if (!$this->pagination_show_numbering) {
            return NULL;
        }
        $result = '';
        if ($this->li) {
            for ($i = 1; $i <= $this->get_pages(); $i++) {
                $result .= '<li' . $this->verify_current($i, $page_param) . '><a href="' . $URL . $i . '">' . $i . '</a></li>';
            }
        } else {
            for ($i = 1; $i <= $this->get_pages(); $i++) {
                $result .= '<a' . $this->verify_current($i, $page_param) . ' href="' . $URL . $i . '">' . $i . '</a>';
            }
        }
        return $result;
    }

    /**
     * call objects for pagination
     * @access private
     * @param String $URL Full URL to the point of parameter pages
     * @param Integer $page_param ID of the page
     * @return Object
     */
    private function call_all_object_pagination($URL, $page_param) {
        return $this->make_button_before($URL, $page_param) . $this->loop($URL, $page_param) . $this->make_button_after($URL, $page_param, $this->get_pages());
    }

    /**
     * check limit page
     * @access private
     * @param String $URL Full URL to the point of parameter pages
     * @param Integer $page_param ID of the page
     * @return string
     */
    private function check_limit($URL, $page_param) {
        if ($this->verify_limit($page_param)) {
            return $this->call_all_object_pagination($URL, $page_param);
        }
    }

    /**
     * create the new paging-numbered
     * bug fix. if the last page shows the pagination, now the query has the lowest records than the limit
     * does not show pagination
     * @access public
     * @param String $URL Full URL to the point of parameter pages
     * @param Integer $page_param ID of the page
     * @return Object
     */
    public function make_pages($URL, $page_param) {
        if ($this->get_pages()) {
            return false;
        } else {
            return isset($page_param) ? $this->check_limit($URL, $page_param) : $this->check_limit($URL, 1);
        }
    }

}
