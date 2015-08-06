<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PaginationHelper extends AbstractHelper
{
    private $resultsPerPage;
    private $totalResults;
    private $results;
    private $baseUrl;
    private $paging;
    private $page;
    private $status;


    public function __invoke($pagedResults, $page, $baseUrl, $limit = 10, $status = null)
    {
        $this->resultsPerPage = $limit;
        $this->totalResults = $pagedResults->count();
        $this->results = $pagedResults;
        $this->baseUrl = $baseUrl;
        $this->page = $page;
        $this->status = $status;
        return $this->generatePaging();
    }

    /**
     * Generate paging html
     */
    private function generatePaging()
    {
        # Get total page count
        $pages = ceil($this->totalResults / $this->resultsPerPage);

        # Don't show pagination if there's only one page
        if($pages == 1) {
            return;
        }

        # Show back to first page if not first page
        if($this->page != 1) {
            $url = $this->baseUrl . '1/' . $this->resultsPerPage;
            if (!empty($this->status)) {
                $url .= '/' . $this->status;
            }
            $this->paging = '<a href="' . $url . '"><<</a>';
        }

        # Create a link for each page
        $pageCount = 1;
        while ($pageCount <= $pages) {
            $url = $this->baseUrl . $pageCount . '/' . $this->resultsPerPage;
            if (!empty($this->status)) {
                $url .= '/' . $this->status;
            }
            if ($this->page == $pageCount) {
                $this->paging .= $pageCount;
                $pageCount ++;
                continue;
            } else {
                $this->paging .= '<a href="' . $url . '">' . $pageCount . '</a>';
                $pageCount ++;
            }
            
        }

        # Show go to last page option if not the last page
        
        if ($this->page != $pages && $this->totalResults > 0) {
            $url = $this->baseUrl . $pages . '/' . $this->resultsPerPage;
            if (!empty($this->status)) {
                $url .= '/' . $this->status;
            }
            $this->paging .= '<a href="' . $url . '">>></a>';
        }

        return $this->paging;
    }
}
