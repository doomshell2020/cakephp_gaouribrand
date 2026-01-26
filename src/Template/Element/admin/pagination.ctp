<div class="paginator col-sm-12" align="right">
  <ul class="pagination">
    <?= $this->Paginator->first('<< ' . __('First')) ?>
    <?= $this->Paginator->prev('< ' . __('Previous')) ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next(__('Next') . ' >') ?>
    <?= $this->Paginator->last(__('Last') . ' >>') ?>
  </ul>
  <div class="col-sm-6" style="margin-left:-29px;" >
 <p align="left"><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
 </div>
</div>

<style type="text/css">
.pagination {
    margin: 10px 0 2px; 
}
p {
    margin: 10px 0 2px;
}
</style>
