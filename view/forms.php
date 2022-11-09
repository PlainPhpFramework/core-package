<?php
use pp\Form\Element;
use pp\Form\ViewHelper;

function label_for(Element $element, array $attr = [])
{
	return ViewHelper::label_for($element, $attr);
}

function attr_for(Element $element, array $attr = [])
{
	return ViewHelper::attr($element->attributes, $attr);
}

function html_attr(array ...$attributes)
{
    return ViewHelper::attr(...$attributes);
}

function form_set_theme($themeName)
{
    ViewHelper::$paths = ['view/form-themes/'.$themeName];
    if($boot = ViewHelper::resolve_path('bootstrap.php')) {
        include $boot;
    }
}
function form_add_theme($themeName)
{
    ViewHelper::$paths[] = 'view/form-themes/'.$themeName;
}

function form_resolve_path($file)
{
    return ViewHelper::resolve_path($file);
}

function form($form, $theme = 'bootstrap-5')
{

    form_set_theme($theme);
    
    include form_resolve_path('form_open.php');
    echo form_widget($form);
    include form_resolve_path('form_close.php');
    
}

function form_widget(Element $element)
{
   
    $view = strtolower(basename(get_class($element))) . '.php';

    if ($path = form_resolve_path($view)) {

        include $path;

    } elseif ($parents = class_parents($element)) {

        foreach ($parents as $parentClass) {
            $view = strtolower(basename($parentClass)) . '.php';

            if ($path = form_resolve_path($view)) {
                include $path;
                break;
            }
        }

    }

    if (!$path) {
        throw new \LogicException('No view found for the form element ' . get_class($element));
    }

}