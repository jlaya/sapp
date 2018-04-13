<?php

/* gestion/pdf/gestion_pdf.twig */
class __TwigTemplate_0c907715cfb6656ea3a03a6dddc420421310db6e4697f12b6f4a046aee3c1b0f extends Twig_Template
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
        echo "<!DOCTYPE html>
<html>
<head>
\t";
        // line 4
        echo link_tag("assets/css/bootstrap.min.css");
        echo "\t
\t";
        // line 5
        echo link_tag("assets/css/general.css");
        echo "
\t<style type=\"text/css\">
\t\t.bold{
\t\t\tfont-weight: bold !important;
\t\t}
\t\t.text-right{
\t\t\ttext-align: right;
\t\t}
\t\t.text-left{
\t\t\ttext-align: left;
\t\t}
\t\t.background{
\t\t\tbackground-color: #8B1C1C !important;
\t\t}
\t</style>
</head>
<body>

\t<img src=\"";
        // line 23
        echo twig_escape_filter($this->env, (base_url() . "assets/image/logo_aragua.jpg"), "html", null, true);
        echo "\" alt=\"\" width=\"140px\" height=\"140px\">
\t<br>

\t<table style=\"width:100%;text-align: center;margin-top: 0%;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\t";
        // line 29
        if (((isset($context["param"]) ? $context["param"] : null) == 1)) {
            // line 30
            echo "\t\t\t\t\tAcción Centralizada
\t\t\t\t";
        } else {
            // line 32
            echo "\t\t\t\t\tProyecto
\t\t\t\t";
        }
        // line 34
        echo "\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tI. Datos Básicos de Identificación
\t\t\t</td>
\t\t</tr>
\t</table>
\t<table style=\"width:100%;text-align: center;margin-top: -1.5%;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">
\t\t\t\tEntidad Político-Territorial
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">";
        // line 47
        echo twig_escape_filter($this->env, (isset($context["nom_ins"]) ? $context["nom_ins"] : null), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Código</td>
\t\t\t<td class=\"text-left\">";
        // line 51
        echo twig_escape_filter($this->env, (isset($context["codigo"]) ? $context["codigo"] : null), "html", null, true);
        echo "</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Monto total</td>
\t\t\t<td class=\"text-right\">";
        // line 53
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["monto"]) ? $context["monto"] : null), 2, ",", "."), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" colspan=\"4\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tII. Metas Físicas
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">
\t\t\t\tAcción Centralizada
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">";
        // line 64
        echo twig_escape_filter($this->env, (isset($context["accion_centralizada"]) ? $context["accion_centralizada"] : null), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">
\t\t\t\tAcción Especifica
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">";
        // line 70
        echo twig_escape_filter($this->env, (isset($context["accion_especifica"]) ? $context["accion_especifica"] : null), "html", null, true);
        echo "</td>
\t\t</tr>
\t</table>
\t<table style=\"width:100%;text-align: center;margin-top: -1.5%;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"width: 20%;\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Plan de Actividad</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Unidad de Medida</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Medio de Verifiación</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Cantidad Planificada</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Cantidad Ejecutada</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">% de Cumplimiento</td>
\t\t</tr>
\t\t";
        // line 82
        $context["porcentaje_total"] = 0;
        // line 83
        echo "\t\t";
        $context["ejecutado"] = 0;
        // line 84
        echo "\t\t";
        $context["cantidad"] = 0;
        // line 85
        echo "\t\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["act_acc"]) ? $context["act_acc"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 86
            echo "\t\t\t<tr>
\t\t\t\t<td style=\"width: 20%;\" class=\"text-left\">";
            // line 87
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "actividad", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td class=\"text-left\">";
            // line 88
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "unidad_medida", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td class=\"text-left\">";
            // line 89
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "medio_verificacion", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td>";
            // line 90
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "cantidad", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td>";
            // line 91
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "ejecutado", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td>";
            // line 92
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "porcentaje", array()), "html", null, true);
            echo "%</td>
\t\t\t</tr>
\t\t\t";
            // line 94
            $context["ejecutado"] = ((isset($context["ejecutado"]) ? $context["ejecutado"] : null) + $this->getAttribute($context["row"], "ejecutado", array()));
            // line 95
            echo "\t\t\t";
            $context["cantidad"] = ((isset($context["cantidad"]) ? $context["cantidad"] : null) + $this->getAttribute($context["row"], "cantidad", array()));
            // line 96
            echo "\t\t\t";
            $context["porcentaje_total"] = (((isset($context["ejecutado"]) ? $context["ejecutado"] : null) / (isset($context["cantidad"]) ? $context["cantidad"] : null)) * 100);
            // line 97
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 98
        echo "\t\t\t<!--<tr>
\t\t\t\t<td colspan=\"5\"></td>
\t\t\t\t<td class='align-center text-right' style='font-weight: bold;'>";
        // line 100
        echo twig_escape_filter($this->env, (isset($context["porcentaje_total"]) ? $context["porcentaje_total"] : null), "html", null, true);
        echo "</td>
\t\t\t</tr>-->
\t</table>
\t<!-- Metas financieras -->
\t<table style=\"width:100%;text-align: center;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" colspan=\"5\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tIII. Metas Financieras
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">Partida</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Descripción</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Monto</td>
\t\t\t<!--<td class=\"bold\">Monto Ejecutado</td>-->
\t\t\t<!--<td class=\"bold\">% de Cumplimiento</td>-->
\t\t</tr>
\t\t";
        // line 117
        $context["sum_total"] = 0;
        // line 118
        echo "\t\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["meta_financiera"]) ? $context["meta_financiera"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 119
            echo "\t\t<tr>
\t\t\t<td style=\"width: 20%;\">";
            // line 120
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "estructura", array()), "html", null, true);
            echo "</td>
\t\t\t<td class=\"text-left\" style=\"width: 50%;\">";
            // line 121
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "partida", array()), "html", null, true);
            echo "</td>
\t\t\t<td class=\"text-right\" style=\"width: 30%;\">";
            // line 122
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["row"], "compromiso", array()), 2, ",", "."), "html", null, true);
            echo "</td>
\t\t\t<!--<td>";
            // line 123
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "partida", array()), "html", null, true);
            echo "</td>-->
\t\t\t<!--<td>% de Cumplimiento</td>-->
\t\t</tr>
\t\t";
            // line 126
            $context["sum_total"] = ((isset($context["sum_total"]) ? $context["sum_total"] : null) + $this->getAttribute($context["row"], "compromiso", array()));
            // line 127
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 128
        echo "\t\t<tr>
\t\t\t<td></td>
\t\t\t<td></td>
\t\t\t<td class='align-center text-right' style='font-weight: bold;'>";
        // line 131
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["sum_total"]) ? $context["sum_total"] : null), 2, ".", ","), "html", null, true);
        echo "</td>
\t\t</tr>
\t</table>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "gestion/pdf/gestion_pdf.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  253 => 131,  248 => 128,  242 => 127,  240 => 126,  234 => 123,  230 => 122,  226 => 121,  222 => 120,  219 => 119,  214 => 118,  212 => 117,  192 => 100,  188 => 98,  182 => 97,  179 => 96,  176 => 95,  174 => 94,  169 => 92,  165 => 91,  161 => 90,  157 => 89,  153 => 88,  149 => 87,  146 => 86,  141 => 85,  138 => 84,  135 => 83,  133 => 82,  118 => 70,  109 => 64,  95 => 53,  90 => 51,  83 => 47,  68 => 34,  64 => 32,  60 => 30,  58 => 29,  49 => 23,  28 => 5,  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
\t{{ link_tag('assets/css/bootstrap.min.css') }}\t
\t{{ link_tag('assets/css/general.css') }}
\t<style type=\"text/css\">
\t\t.bold{
\t\t\tfont-weight: bold !important;
\t\t}
\t\t.text-right{
\t\t\ttext-align: right;
\t\t}
\t\t.text-left{
\t\t\ttext-align: left;
\t\t}
\t\t.background{
\t\t\tbackground-color: #8B1C1C !important;
\t\t}
\t</style>
</head>
<body>

\t<img src=\"{{ base_url() ~ 'assets/image/logo_aragua.jpg' }}\" alt=\"\" width=\"140px\" height=\"140px\">
\t<br>

\t<table style=\"width:100%;text-align: center;margin-top: 0%;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\t{% if param == 1 %}
\t\t\t\t\tAcción Centralizada
\t\t\t\t{% else %}
\t\t\t\t\tProyecto
\t\t\t\t{% endif %}
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tI. Datos Básicos de Identificación
\t\t\t</td>
\t\t</tr>
\t</table>
\t<table style=\"width:100%;text-align: center;margin-top: -1.5%;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">
\t\t\t\tEntidad Político-Territorial
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">{{ nom_ins }}</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Código</td>
\t\t\t<td class=\"text-left\">{{ codigo }}</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Monto total</td>
\t\t\t<td class=\"text-right\">{{ monto|number_format(2, ',', '.') }}</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" colspan=\"4\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tII. Metas Físicas
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">
\t\t\t\tAcción Centralizada
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">{{ accion_centralizada }}</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">
\t\t\t\tAcción Especifica
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">{{ accion_especifica }}</td>
\t\t</tr>
\t</table>
\t<table style=\"width:100%;text-align: center;margin-top: -1.5%;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"width: 20%;\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Plan de Actividad</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Unidad de Medida</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Medio de Verifiación</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Cantidad Planificada</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Cantidad Ejecutada</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">% de Cumplimiento</td>
\t\t</tr>
\t\t{% set porcentaje_total = 0 %}
\t\t{% set ejecutado = 0 %}
\t\t{% set cantidad = 0 %}
\t\t{% for row in act_acc %}
\t\t\t<tr>
\t\t\t\t<td style=\"width: 20%;\" class=\"text-left\">{{ row.actividad }}</td>
\t\t\t\t<td class=\"text-left\">{{ row.unidad_medida }}</td>
\t\t\t\t<td class=\"text-left\">{{ row.medio_verificacion }}</td>
\t\t\t\t<td>{{ row.cantidad }}</td>
\t\t\t\t<td>{{ row.ejecutado }}</td>
\t\t\t\t<td>{{ row.porcentaje }}%</td>
\t\t\t</tr>
\t\t\t{% set ejecutado = ejecutado + row.ejecutado%}
\t\t\t{% set cantidad  = cantidad + row.cantidad%}
\t\t\t{% set porcentaje_total = (ejecutado / cantidad) * 100 %}
\t\t{% endfor %}
\t\t\t<!--<tr>
\t\t\t\t<td colspan=\"5\"></td>
\t\t\t\t<td class='align-center text-right' style='font-weight: bold;'>{{ porcentaje_total }}</td>
\t\t\t</tr>-->
\t</table>
\t<!-- Metas financieras -->
\t<table style=\"width:100%;text-align: center;\" border=\"0\" align=\"center\" cellspacing=\"1\" align=\"center\" class=\"table table-bordered table-striped table-hover table-condensed dt-responsive table-responsive\">
\t\t<tr>
\t\t\t<td class=\"bold\" colspan=\"5\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tIII. Metas Financieras
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">Partida</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Descripción</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Monto</td>
\t\t\t<!--<td class=\"bold\">Monto Ejecutado</td>-->
\t\t\t<!--<td class=\"bold\">% de Cumplimiento</td>-->
\t\t</tr>
\t\t{% set sum_total = 0 %}
\t\t{% for row in meta_financiera %}
\t\t<tr>
\t\t\t<td style=\"width: 20%;\">{{ row.estructura }}</td>
\t\t\t<td class=\"text-left\" style=\"width: 50%;\">{{ row.partida }}</td>
\t\t\t<td class=\"text-right\" style=\"width: 30%;\">{{ row.compromiso|number_format(2, ',', '.') }}</td>
\t\t\t<!--<td>{{ row.partida }}</td>-->
\t\t\t<!--<td>% de Cumplimiento</td>-->
\t\t</tr>
\t\t{% set sum_total = sum_total + row.compromiso%}
\t\t{% endfor %}
\t\t<tr>
\t\t\t<td></td>
\t\t\t<td></td>
\t\t\t<td class='align-center text-right' style='font-weight: bold;'>{{ sum_total|number_format(2, '.', ',') }}</td>
\t\t</tr>
\t</table>

</body>
</html>", "gestion/pdf/gestion_pdf.twig", "/var/www/html/sapp/application/views/gestion/pdf/gestion_pdf.twig");
    }
}
