<?php
    use Core\Request;
    $request = new Request();
    $page = $request->get('p');
    if(!$page || $page < 1) $page = 1;
    $limit = $request->get('limit')? $request->get('limit') : 25;
    $totalPages = ceil($this->total / $limit);
    $canBack = $page > 1;
    $canForward = $page < $totalPages;

?>

<form action="" method="get" id="pagerForm" onsubmit="return false;">
    <div class="d-flex justify-content-center align-items-center my-5">
     <input type="hidden" id="p" name="p", value="<?= $page ?>" />
     <input type="hidden" name="limit", value="<?=$limit ?>" />

     <button class="btn btn-sm btn-info" <?=$canBack? "" : "disable" ?> onclick="pager(<?= $page -1?>)"><</button>
     <div class="mx-3"><?=$page?> / <?=$totalPages?></div>
     <button class="btn btn-sm btn-info" <?=$canForward? "" : "disable" ?> onclick="pager(<?= $page +1?>)">></button>

    </div>
</form>

<script>
    // Find the page and finding the form and submited
    function pager($page){
        document.getElementById('p').value = page;
        let form = document.getElementById('pagerForm');
        form.submit();
    }       
</script>