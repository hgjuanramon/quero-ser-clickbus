<?php

/* AcmeDemoBundle:Ordenacion:index.html.twig */
class __TwigTemplate_67e41b99af56c69997e6b6b18b8e6eebeec7f2447e393195d2c48ebfd4073bce extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "
<h1 class=\"title\">Ordenacion</h1>
<ul id=\"demo-list\">
    <pre> ";
        // line 4
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context, (isset($context["groups"]) ? $context["groups"] : $this->getContext($context, "groups"))), "html", null, true);
        echo "</pre>
</ul>
";
    }

    public function getTemplateName()
    {
        return "AcmeDemoBundle:Ordenacion:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
    }
}
