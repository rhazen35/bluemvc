<?php

namespace app\core;

class Pagination
{
    //////////////////////////////////////// Pagination options ////////////////////////////////////////
    protected $totalRows;
    protected $limit;
    protected $pageNumber;

    private $paginationOpts = array(
        'linkCount' => 8
    );
    //////////////////////////// Create some parameters for pagination layout /////////////////////////

    public function __construct( $totalRows, $limit, $pageNumber )
    {
        $this->totalRows = $totalRows;
        $this->limit = $limit;
        $this->pageNumber = $pageNumber;
    }

    private function getPaginationParams($pageNumber, $totalPages)
    {
        // Get linkCount from options variable
        $linkCount = $this->paginationOpts['linkCount'];

        $linkRange = ceil($linkCount / 2);

        // Determine how many links to show before and after the current page,
        // depending on total number of pages and current page position.
        if($linkCount > 0):

            // the number of page links before the current page
            $linksBefore = ($pageNumber <= $linkRange) ? ($pageNumber - 1) : $linkRange;

            // the number of page links after the current page
            $linksAfter = ($pageNumber <= ($totalPages - $linkRange)) ? $linkRange : ($totalPages - $pageNumber);

            // If links before is less than half of the link count: add the difference to the links after.
            if($linksBefore < $linkRange):

                // specify the number of links to add extra after the current page
                $spareLinkSpots = $linkRange - $linksBefore;

                // if adding the extra links after doesn't result in exceeding the total number of pages
                if(($pageNumber + $linksAfter + $spareLinkSpots) <= $totalPages)
                    $linksAfter = ($linksAfter + $spareLinkSpots);

                // else draw all pages after the current page
                else
                    $linksAfter = $totalPages - $pageNumber;
            endif;

            // If links after is less than half of the link count: add the difference to the links before.
            if($linksAfter < $linkRange):

                // specify the number of links to add extra before the current page
                $spareLinkSpots = $linkRange - $linksAfter;

                // if adding the extra links before doesn't result in exceeding minimum page number of 1
                if($pageNumber - $linksBefore - $spareLinkSpots >= 1)
                    $linksBefore = $linksBefore + $spareLinkSpots;

                // else draw all the pages before the current page
                else
                    $linksBefore = $pageNumber - 1;
            endif;

            // Booleans: Determine wether we should draw first and last page links,
            // depending on if the range of the page links reaches the start and end of the pagination
            $drawFirstPage = $pageNumber - $linksBefore > 1;
            $drawLastPage = $pageNumber + $linksAfter < $totalPages;

            // Create array with data to return to createPagination
            $paginationParams = array (
                'linksBefore'   => $linksBefore,
                'linksAfter'    => $linksAfter,
                'drawFirstPage' => $drawFirstPage,
                'drawLastPage'  => $drawLastPage
            );
        endif;

        return $paginationParams;
    }

    public function createPagination ( $data_url )
    {
        // Determine total number of pages
        $totalPages = $lastPage = ceil($this->totalRows / $this->limit);
        //////////////////
        if(isset($_POST['pagePropertiesSubmit'])):
            $pageNumber = 1;
        else:
            $pageNumber = $this->pageNumber;
        endif;
        // Ensure by override that page number is in range (between 1 and total number of pages)
        $pageNumber = max($pageNumber, 1);
        $pageNumber = min($pageNumber, $totalPages);
        // Get pagination parameters
        $paginationParams = $this->getPaginationParams($pageNumber, $totalPages);
        // Create markup string variable
        $markup = '<div class="pagination">';
        //////////////////// Draw pagination Intro ////////////////////
        $markup .= '<div class="paginationFlex">';
        $markup .= '<div class="pagination-title">Page '.$pageNumber.' of '.$totalPages.'</div>';
        $markup .= '</div>';

        //////////////////// Draw 'previous' link ////////////////////

        if($pageNumber > 1):
            $previous = $pageNumber - 1;
            $markup .= '<div class="paginationFlex">';
            $markup .= '<div class="pagination-link">';
            $markup .= '<a href="" data-page="' . $previous . '" data-url="' . BASE_PATH . $data_url . '" class="paginate">Previous</a>';
            $markup .= '</div>';
            $markup .= '</div>';
        endif;


        //////////////////// Draw first page ////////////////////

        if($paginationParams['drawFirstPage']):
            $markup .= '<div class="paginationFlex">';
            $markup .= '<div class="pagination-link">';
            $markup .= '<a href=""  data-page="' . 1 . '" data-url="' . BASE_PATH . $data_url . '" class="paginate">1...</a>';
            $markup .= '</div>';
            $markup .= '</div>';
        endif;


        //////////////////// Draw previous page sequence ////////////////////


        for($i = $pageNumber - $paginationParams['linksBefore']; $i < $pageNumber; $i++):
            $markup .= '<div class="paginationFlex">';
            $markup .= '<div class="pagination-link">';
            $markup .= '<a href="" data-page="' . $i . '" data-url="' . BASE_PATH . $data_url . '" class="paginate">' . $i . '</a>';
            $markup .= '</div>';
            $markup .= '</div>';
        endfor;


        //////////////////// Draw current page ////////////////////

        $markup .= '<div class="paginationFlex">';
        $markup .= '<div class="pagination-current">';
        $markup .= $pageNumber;
        $markup .= '</div>';
        $markup .= '</div>';


        //////////////////// Draw next pages sequence ////////////////////


        for($i = $pageNumber+1, $l = $paginationParams['linksAfter']; $l > 0; $i++, $l--):
            $markup .= '<div class="paginationFlex">';
            $markup .= '<div class="pagination-link">';
            $markup .= '<a href="" data-page="' . $i . '" data-url="' . BASE_PATH . $data_url . '" class="paginate">'.$i.'</a> ';
            $markup .= '</div>';
            $markup .= '</div>';
        endfor;


        //////////////////// Draw last page ////////////////////

        if($paginationParams['drawLastPage']):
            $markup .= '<div class="paginationFlex">';
            $markup .= '<div class="pagination-link">';
            $markup .= '<a href=""  data-page="' . $lastPage . '" data-url="' . BASE_PATH . $data_url . '" class="paginate">...'.$lastPage.'</a>';
            $markup .= '</div>';
            $markup .= '</div>';
        endif;


        //////////////////// Draw 'next' link ////////////////////

        if($pageNumber < $lastPage):
            $next = $pageNumber + 1;
            $markup .= '<div class="paginationFlex">';
            $markup .= '<div class="pagination-link">';
            $markup .= '<a href="" data-page="' . $next . '" data-url="' . BASE_PATH . $data_url . '" class="paginate">Next</a>';
            $markup .= '</div>';
            $markup .= '</div>';
        endif;


        //////////////////// Finish and echo ////////////////////

        $markup .= '</div>';
        return($markup);
    }
}
?>