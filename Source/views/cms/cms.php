
<?php include 'views/admin/top.php'; ?>


<div class="transactionsactions">
	<a href="?con=admin&page=create-page" class="button" >NEW PAGE</a>
</div>

<?php if ($cms){ ?>
<table cellpadding="0" cellspacing="0">

	<tr>
		<th>id #</th>
		<th>Name </th>
		<th>Title </th>
		<th>Edit </th>
		<th>Delete </th>

	</tr>

	<tbody>

                <?php  foreach($cms as $cms_page){ ?>
		<tr>
			<td><?=$cms_page['id']?></td>
			<td><?=$cms_page['name']?></td>
			<td><?=$cms_page['title']?></td>
			<td><a href="?con=admin&page=create-page&name=<?=$cms_page['name']?>" class="taction">EDIT</a></td>
                        <td><a href="?con=admin&page=delete-page&name=<?=$cms_page['name']?>" class="taction">DELETE</a></td>
                            
		</tr>
                <?php } ?>
                
		<tr>
			







	</tbody>


</table>
            		<?= mypaging ($pages_count, $page_no, 'href="?con=admin&page=cms&page-no={page}" class="{active}"') ?>
<?php } else { ?>

		<div class="nocontentfound">
			There are no CMS pages 
		</div>
<?php } ?>
