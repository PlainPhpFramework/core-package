<?php ob_start() ?>
<input <?=attr_for($element, ['alt' => $element->getLabel()])?>>
<?php
$content = ob_get_clean();
require form_resolve_path('row.php');