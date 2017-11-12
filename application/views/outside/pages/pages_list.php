<div class="content-wrapper wrapper">
 	<div class="container">
		<div class="float-holder">
			<div class="content_list" style="">
				<h3 class="page-heading">
					<span>
					<a href="/content/plist/">Статьи</a>

				</h3>
				
		<?php foreach ($pages_list_arr as $page) { $not_empty = true;?>

				<article class="img_shadow p10 mb10">

					<?php if ($page['content_img'] != '') { ?>
					<a href="/content/al/<?=$page['content_alias']?>">
						<img class="fleft w200 img_shadow p10 m15" src="/files/uploads/content_img/<?=$page['content_img']?>" alt="<?=$page['content_name']?>" />
					</a>
					<?php } ?>
					<h4><a href="/content/al/<?=$page['content_alias']?>"><?=$page['content_name']?></a></h4>
					<?=$page['content_desc']?>

					<a href="/content/al/<?=$page['content_alias']?>" class="read-more">Подробнее... &#8594;</a>

					<div class="clearfix"></div>

				</article>
							
	<?php } ?>
			

			
				<div class="pagination">
					<?=$pagination?>
				</div>
			
			
			</div>
			
		</div>
<?php if (!isset($not_empty)) {?>
<h3 style="margin-left:50px; margin-top: 190px;">Нет страниц в данном разделе</h3>
<?php } ?>			
		
  	</div>
</div>
	  
			