<?php


/**
 * MIT License
 *
 * Copyright (c) 2017 Tomiwa Ibiwoye <tommylykerin@gmail.com> @tommylykerin
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */


/**
 * Class Paginator
 */
class Paginator
{
	private $_total;
	private $_items_per_page;
	private $_page_var_name;
	private $_page;
	private $_links_range;

	/**
	 * Paginator constructor.
	 * @param       integer|int     $total              Total number of items
	 * @param       integer|int     $items_per_page     Items to be displayed per page
	 * @param       string          $page_var_name      The name of the get variable holding page numbers
	 * @param       integer|int     $links_range        The number of page links to be displayed plus and minus of the current page link
	 *
	 * @throws      Exception
	 */
	public function __construct($total, $items_per_page, $page_var_name='page', $links_range = 2) {
		// Ensures the passed $total is an integer and throws an exception if not
		if(is_numeric($total)){
			$this->_total = $total;
		}else{
			throw new \Exception("Integer value expected for total number of items, ".gettype($total)." given.");
		}

		// Ensures the passed $items_per_page is an integer and throws an exception if not
		if(is_numeric($items_per_page)){
			$this->_items_per_page = $items_per_page;
		}else{
			throw new \Exception("Integer value expected for items per page, ".gettype($items_per_page)." given.");
		}

		// Ensures the passed $page_var_name is a string and throws an exception if not
		if(is_string($page_var_name)){
			$this->_page_var_name = $page_var_name;
		}else {
			throw new \Exception("String value expected for page variable name, ".gettype($page_var_name)." given.");
		}

		// Ensures the passed $links_range is an integer and throws an exception if not
		if(is_numeric($links_range)){
			$this->_links_range = $links_range;
		}else{
			throw new \Exception("Integer value expected for links range, ".gettype($links_range)." given.");
		}

		// gets the current page from the url $_GET variables or sets it to 1 if not set
		$this->_page = !empty($_GET[$this->_page_var_name])? $_GET[$this->_page_var_name] : 1;
	}

	/**
	 * @param       string      $ul_class       CSS class for pagination's ul tag
	 * @param       string      $li_class       CSS class for pagination's ul>li tag
	 * @param       string      $a_class        CSS class for pagination's ul>li>a tag
	 * @param       string      $active         CSS class for active links
	 * @param       string      $disabled       CSS class for disabled links
	 *
	 * @return string
	 */
	public function paginate($ul_class="pagination pagination-sm", $li_class="page-item", $a_class="page-link", $active="active", $disabled="disabled") {
		$link = preg_replace('#('.$this->_page_var_name.'=[0-9]+)#', "", $_SERVER['REQUEST_URI']);
		$i = strpos($link, '?');
		$j = preg_match('#&$#', $link);
		$k = preg_match('#\?$#', $link);
		$link .= $i ? ($j? '':($k? '':'&')) : '?';

		$last       = ceil( $this->_total / $this->_items_per_page );

		$start      = ( ( $this->_page - $this->_links_range ) > 0 ) ? $this->_page - $this->_links_range : 1;
		$end        = ( ( $this->_page + $this->_links_range ) < $last ) ? $this->_page + $this->_links_range : $last;

		$html       = '<ul class="' . $ul_class . '">';

		$class      = ( $this->_page == 1 ) ? $disabled : "";
		$html       .= '<li class="'.$li_class.' ' . $class . '"><a class="'.$a_class.'" href="'.$link.$this->_page_var_name.'=' . ( $this->_page - 1 ) . '"><i>&lt;&lt;</i></a></li>';

		if ( $start > 1 ) {
			$html   .= '<li class="'.$li_class.'"><a class="'.$a_class.'" href='.$link.$this->_page_var_name.'=1>1</a></li>';
			if($start != 2) {
				$html .= '<li class="'.$li_class.' '.$disabled.'"><span class="'.$a_class.'">...</span></li>';
			}
		}

		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? $active : "";
			$html   .= '<li class="'.$li_class.' ' . $class . '"><a class="'.$a_class.'" href="'.$link.$this->_page_var_name.'=' . $i . '">' . $i . '</a></li>';
		}

		if ( $end < $last ) {
			if($end != $last-1) {
				$html .= '<li class="'.$li_class.' '.$disabled.'"><span class="'.$a_class.'">...</span></li>';
			}
			$html   .= '<li class="'.$li_class.'"><a class="'.$a_class.'" href="'.$link.$this->_page_var_name.'=' . $last . '">' . $last . '</a></li>';
		}

		$class      = ( $this->_page == $last ) ? $disabled : "";
		$html       .= '<li class="'.$li_class.' ' . $class . '"><a class="'.$a_class.'" href="'.$link.$this->_page_var_name.'=' . ( $this->_page + 1 ) . '"><i>&gt;&gt;</i></a></li>';

		$html       .= '</ul>';

		return $html;
	}
}