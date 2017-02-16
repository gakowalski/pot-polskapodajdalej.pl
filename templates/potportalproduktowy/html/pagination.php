<?php
/**
 * @version        $Id: pagination.php 9764 2007-12-30 07:48:11Z ircmaxell $
 * @package        Joomla
 * @copyright    Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license        GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 *     Input variable $list is an array with offsets:
 *         $list[limit]        : int
 *         $list[limitstart]    : int
 *         $list[total]        : int
 *         $list[limitfield]    : string
 *         $list[pagescounter]    : string
 *         $list[pageslinks]    : string
 *
 * pagination_list_render
 *     Input variable $list is an array with offsets:
 *         $list[all]
 *             [data]        : string
 *             [active]    : boolean
 *         $list[start]
 *             [data]        : string
 *             [active]    : boolean
 *         $list[previous]
 *             [data]        : string
 *             [active]    : boolean
 *         $list[next]
 *             [data]        : string
 *             [active]    : boolean
 *         $list[end]
 *             [data]        : string
 *             [active]    : boolean
 *         $list[pages]
 *             [{PAGE}][data]        : string
 *             [{PAGE}][active]    : boolean
 *
 * pagination_item_active
 *     Input variable $item is an object with fields:
 *         $item->base    : integer
 *         $item->link    : string
 *         $item->text    : string
 *
 * pagination_item_inactive
 *     Input variable $item is an object with fields:
 *         $item->base    : integer
 *         $item->link    : string
 *         $item->text    : string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_footer($list)
{
    $html = "<div class=\"list-footer\">\n";

    $html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
    $html .= $list['pageslinks'];
    $html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";

    $html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
    $html .= "\n</div>";

    return $html;
}

// możliwość wykorzystanai obiektu paginacji poprzez this
function pagination_list_render($list, $_this = null)
{
    $startPage = '';
    $endPage = '';
    
    // pobieramy aplikacjie, aby pobrac page limit
    $app =& JFactory::getApplication();
    $pageLimit = (int)$app->getCfg('page_limit');
    if($pageLimit == 0) $pageLimit = 10;    
    
    if(!is_null($_this) && $_this->get('pages.total') > $pageLimit)
    {        
        // numery pierwszej i ostatniej strony
        $startPageNumber = 1;
        $endPageNumber = $_this->get('pages.total');    
        
        // aktualna i ostatnia strona
        $currentPage = $_this->get('pages.current');
        $lastPage = $_this->get('pages.total');
        
        // pobieramy dane paginacji
        $data = $_this->getData();

        if ($data->start->base !== null) {
            $list['start']['active'] = true;
            $list['start']['data'] = "<a class=\"pagitem\" href=\"".$data->start->link."\" title=\"".$data->start->text."\">".$startPageNumber."</a>";
        }
        
        if ($data->end->base !== null) {
            $list['end']['active'] = true;
            $list['end']['data'] = "<a class=\"pagitem\" href=\"".$data->end->link."\" title=\"".$data->end->text."\">".$endPageNumber."</a>";
        }
        
        if($currentPage > $pageLimit)
            $startPage = '<span class="pagitem-page">' . $list['start']['data'] . '</span><span class="pagitem pagitem-dots">...</span>';
        
        if($currentPage < ($lastPage - ($lastPage % $pageLimit)) || ($currentPage == ($lastPage - ($lastPage % $pageLimit)) && ($lastPage % $pageLimit)))
            $endPage = '<span class="pagitem pagitem-dots">...</span><span class="pagitem-page">' . $list['end']['data'] . '</span>';
    }
    
    // Initialize variables
    $html = "<div class=\"pagination\">";

    $html .= $startPage;
    
    foreach( $list['pages'] as $page )
    { 
        $html .= '<span class="pagitem-page">' . $page['data'] . '</span>';
    }
    
    $html .= $endPage;

    $html .= "</div>";
    return $html;
}

function pagination_item_active(&$item) {
    return "<a class=\"pagitem\" href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a>";
}

function pagination_item_inactive(&$item) {
    return "<span class=\"pagitem\">".$item->text."</span>";
}
?>