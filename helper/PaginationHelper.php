<?php
if(!function_exists('createlink'))
{
    function createlink($data = [])
    {
        //create link
        //'Search' = $keyword

        $linkPage ='';
        foreach($data as $key =>$value)
        {
            $linkPage .= empty($linkPage) ? "?{$key}={$value}" : "&{$key}={$value}";

        }
        return APP_ROOT_PATH . $linkPage;
        //index.php?c=department&mindex&page={page}&search=
    }
    if(!function_exists('pagination'))
    {
        function pagination($link,$totalItems , $page =1 , $limit =2)
        {
            //$link : duong link can lay tu ham cretelink
            //totolItem: tong so du lieu can phan trang
            // $page : trang hien tai cua nguoi dung dang xem du lieu
            // limit: so dong du lieu can xem tran 1 trang
            //trong Mysql -SQL Server có từ khóa LIMIT start, rows
            // start: vị trí dòng dữ liệu dc lấy ra(dòng đầu tiên  từ 0)
            //rows : os dòng dữ liệu muốn lấy ra là bn
            $totalPage = ceil($totalItems / $limit);
            //ceil : lamf tron so trong php "(lam tron )
            if($page < 1 ||$totalPage == 0) 
            {
                $page =1;
            }
            elseif($page > $totalPage){
                $page=$totalItems;
            }
            $start = ($totalPage == 0) ? 0 : (($page-1) *$limit);
            //di xay dung template phan trang = bootstrap)
            $htmlPage ='';
            $htmlPage.='<nav>';
            $htmlPage.='<ul class="pagination">';
           if($page>1)
           {
            $htmlPage.='<li class="page-item">';
            $htmlPage.='<a href="'.str_replace('{page}', $page-1, $link).'" class="page-link">Previous</a>';
            $htmlPage.='</li>';
           }
           //xu li cas trsang
           for($i = 1; $i <= $totalPage; $i++)
           {
               if($i == $page)
               {
                   $htmlPage.=' <li class="page-item active" aria-current="page">';
                   $htmlPage.= ' <a class="page-link" >'.$page.'</a>';
                   $htmlPage.='</li>';
               }
               else
               {
                //cac trang khac
                   $htmlPage.='<li class="page-item">';
                   $htmlPage.= '<a href="'.str_replace('{page}', $i, $link).'" class="page-link">'.$i.'</a>';
                   $htmlPage.='</li>';
               }
           }
           //xu li cac trang khac
           if($page<$totalPage)
           {
               $htmlPage.='<li class="page-item">';
               $htmlPage.='<a href="'.str_replace('{page}', $page+1, $link).'" class="page-link">Next</a>';
               $htmlPage.='</li>';
           }
           $htmlPage.='</ul>';
           $htmlPage.='</nav>';
            return['start' =>$start,
            'htmlPage' =>$htmlPage];
        }
    }
}