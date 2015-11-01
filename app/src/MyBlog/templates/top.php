<?php
/* @var $this \C\View\ConcreteContext */
/* @var $logo string */
?>
<div>
    THE LOGO WTF !! :: <?php echo $logo; ?>
</div>
<?php $this->inlineTo('last'); ?>
<script type="text/javascript">
    console.log('rrr');
</script>
<?php $this->endInline(); ?>
