<?php
if(isset($item) && $item)
{
	$count=count($item);
	$loop=0;
	foreach($item as $key=>$i)
	{
		$loop++;
		if($count==$loop)
		{
			//最後
			if(isset($i['url']) && $i['url'])
			{
				echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><a href="'.$i['url'].'" itemprop="url"><span itemprop="title">'.$i['title'].'</span></a></li>';
			}
			else
			{
				echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active"><span itemprop="title">'.$i['title'].'</span></li>';
			}
			
		}
		else
		{
			//最後
			if(isset($i['url']) && $i['url'])
			{
				echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$i['url'].'" itemprop="url"><span itemprop="title">'.$i['title'].'</span></a></li>';
			}
			else
			{
				echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">'.$i['title'].'</span></li>';
			}
		}
	}
}
?>
