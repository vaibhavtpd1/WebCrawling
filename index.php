<?php
  function showAllLinks($url,$depth)
  {
      $arr=array();
      if($depth==0)
      {
        return;
      }
      else
      {
          $html = file_get_contents($url);
          $dom = new DOMDocument();
          @$dom->loadHTML( $html );
          $hrefs = $dom->getElementsByTagName('a');
          for( $i = 0; $i < $hrefs->length; $i ++ )
          {
            $href = $hrefs->item( $i );
            $subUrl = $href->getAttribute('href');
            $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;
            $arr[]=array(
                "Title:"=>$title,
                "Url:"=>$subUrl,
                "Sublinks:"=>showAllLinks($subUrl,$depth-1)
            );
          }
          return $arr;
      }
}

$url="https://www.drf.com";
$depth=5;
$res=showAllLinks($url,$depth);
$result=json_encode($res);
echo $result;
?>