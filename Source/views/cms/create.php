
<h1 class="inh1">CMS PAGE EDIT:</h1>


<div class="transfer">
    <form action="?con=admin&page=create-page&name=<?=$page_name?>" method="post" ENCTYPE = "multipart/form-data" class="bvalidator">
	<label for="accountnumber">Page name:</label>
	<input type="text" id="name" name="name" value="<?=$cms_page['name']?>" class="txtbox" data-bvalidator="required"/>

	<label for="amount">Page title (EN):</label>
	<input type="text" id="title_en" name="title_en" value="<?=$cms_page['title_en']?>" class="txtbox" data-bvalidator="required"/>

	<label for="amount">Page title (AR):</label>
	<input type="text" id="title_ar" name="title_ar" value="<?=$cms_page['title_ar']?>" class="txtbox" data-bvalidator="required"/>

	
	<label for="amount">Page Body (EN):</label>
        <?=$CKeditor->editor("description_en", $cms_page['description_en'], $ckconfig);?>

	<label for="amount">Page Body (AR):</label>
        <?=$CKeditor->editor("description_ar", $cms_page['description_ar'], $ckconfig);?>

	<label for="image1">Image 1:</label>
	<input type="file" id="image1" name="image1" />
	
	<label for="image2">Image 2:</label>
	<input type="file" id="image2" name="image2" />

	<div class="clear"></div>

	<input type="submit" value="CREATE PAGE" class="btnsubmit"/>
    </form>




</div>