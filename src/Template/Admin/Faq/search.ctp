<table class="table table-bordered table-striped" width="100%" id="example2">
  <thead>
    <tr>
      <th width="5%">S.No</th>
      <th width="5%">FAQ Category</th>
      <th width="15%">Question</th>
      <th width="15%">Answer</th>
      <th width="8%">Created</th>
      <th width="8%">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
    $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
    $counter = ($page * $limit) - $limit + 1;
    if (isset($faq_cat_question) && !empty($faq_cat_question)) {

      foreach ($faq_cat_question as $faq) { //pr($faq);die; 
    ?>
        <tr>
          <td><?php echo $counter;  ?></td>
          <td><?php echo $faq['faq']['name'];  ?></td>
          <td><?php echo $faq['question'];  ?></td>
          <td><?php echo $faq['answer'];  ?></td>
          <td><?php echo date('d M Y', strtotime($faq['created'])); ?></td>
          <td>
            <?php if ($faq['status'] == 'Y') {
              echo $this->Html->link('', [
                'action' => 'question_status',
                $faq->id, 'N'
              ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;color: #36cb3c;']);
            } else {
              echo $this->Html->link('', [
                'action' => 'question_status', $faq->id, 'Y'
              ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
            } ?>

            <?php echo $this->Html->link(__(''), ['action' => 'question_edit', $faq->id,], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit', 'style' => 'font-size: 20px !important; margin-left: 12px;')) ?>

            <?php echo $this->Html->link('', ['action' => 'question_delete', $faq->id], ['title' => 'Delete', 'class' => 'fa fa-trash', 'style' => 'color:#FF0000; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to delete this FAQ Question?')"]); ?>

          </td>
        </tr>
    <?php $counter++;
      }
    } ?>
  </tbody>
</table>