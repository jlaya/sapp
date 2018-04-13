<?php

/* gestion/pdf/accion_centralizada/II.twig */
class __TwigTemplate_499a6b88521d691a1d426461dbf4ff6a75fa615bbefb56e1acfb6b5662eb9909 extends Twig_Template
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
\t\t\t\tTrimestre II Año ";
        // line 29
        echo twig_escape_filter($this->env, (isset($context["ano_fiscal"]) ? $context["ano_fiscal"] : null), "html", null, true);
        echo "
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tAcción Centralizada
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
\t\t\t<td colspan=\"3\" class=\"text-left\">";
        // line 48
        echo twig_escape_filter($this->env, (isset($context["nom_ins"]) ? $context["nom_ins"] : null), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Código</td>
\t\t\t<td class=\"text-left\">";
        // line 52
        echo twig_escape_filter($this->env, (isset($context["codigo"]) ? $context["codigo"] : null), "html", null, true);
        echo "</td>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;\">Monto total</td>
\t\t\t<td class=\"text-right\">";
        // line 54
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
        // line 65
        echo twig_escape_filter($this->env, (isset($context["accion_centralizada"]) ? $context["accion_centralizada"] : null), "html", null, true);
        echo "</td>
\t\t</tr>
\t\t<!--<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">
\t\t\t\tAcción Especifica
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">";
        // line 71
        echo twig_escape_filter($this->env, (isset($context["accion_especifica"]) ? $context["accion_especifica"] : null), "html", null, true);
        echo "</td>
\t\t</tr>-->
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
        // line 83
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["act_acc"]) ? $context["act_acc"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 84
            echo "\t\t\t<tr>
\t\t\t\t<td style=\"width: 20%;\" class=\"text-left\">";
            // line 85
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "actividad", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td class=\"text-left\">";
            // line 86
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "unidad_medida", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td class=\"text-left\">";
            // line 87
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "medio_verificacion", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td>";
            // line 88
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "trimestre_ii", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td>";
            // line 89
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "ii", array()), "html", null, true);
            echo "</td>
\t\t\t\t<td>";
            // line 90
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "porcentaje", array()), "html", null, true);
            echo "%</td>
\t\t\t</tr>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 93
        echo "\t\t\t<!--<tr>
\t\t\t\t<td colspan=\"5\"></td>
\t\t\t\t<td class='align-center text-right' style='font-weight: bold;'>";
        // line 95
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
        // line 112
        $context["sum_total"] = 0;
        // line 113
        echo "\t\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["meta_financiera"]) ? $context["meta_financiera"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 114
            echo "\t\t<tr>
\t\t\t<td style=\"width: 20%;\">";
            // line 115
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "estructura", array()), "html", null, true);
            echo "</td>
\t\t\t<td class=\"text-left\" style=\"width: 50%;\">";
            // line 116
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "partida", array()), "html", null, true);
            echo "</td>
\t\t\t<td class=\"text-right\" style=\"width: 30%;\">";
            // line 117
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, $this->getAttribute($context["row"], "compromiso", array()), 2, ",", "."), "html", null, true);
            echo "</td>
\t\t\t<!--<td>";
            // line 118
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "partida", array()), "html", null, true);
            echo "</td>-->
\t\t\t<!--<td>% de Cumplimiento</td>-->
\t\t</tr>
\t\t";
            // line 121
            $context["sum_total"] = ((isset($context["sum_total"]) ? $context["sum_total"] : null) + $this->getAttribute($context["row"], "compromiso", array()));
            // line 122
            echo "\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 123
        echo "\t\t<tr>
\t\t\t<td></td>
\t\t\t<td></td>
\t\t\t<td class='align-center text-right' style='font-weight: bold;'>";
        // line 126
        echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (isset($context["sum_total"]) ? $context["sum_total"] : null), 2, ".", ","), "html", null, true);
        echo "</td>
\t\t</tr>
\t</table>

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "gestion/pdf/accion_centralizada/II.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  231 => 126,  226 => 123,  220 => 122,  218 => 121,  212 => 118,  208 => 117,  204 => 116,  200 => 115,  197 => 114,  192 => 113,  190 => 112,  170 => 95,  166 => 93,  157 => 90,  153 => 89,  149 => 88,  145 => 87,  141 => 86,  137 => 85,  134 => 84,  130 => 83,  115 => 71,  106 => 65,  92 => 54,  87 => 52,  80 => 48,  58 => 29,  49 => 23,  28 => 5,  24 => 4,  19 => 1,);
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
\t\t\t\tTrimestre II Año {{ ano_fiscal }}
\t\t\t</td>
\t\t</tr>
\t\t<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #8B1C1C !important;color: #FFFFFF; font-weight: bold;\">
\t\t\t\tAcción Centralizada
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
\t\t<!--<tr>
\t\t\t<td class=\"bold\" style=\"background-color: #BFBFBF !important;color: #000000; font-weight: bold;text-align: left;width: 20%;\">
\t\t\t\tAcción Especifica
\t\t\t</td>
\t\t\t<td colspan=\"3\" class=\"text-left\">{{ accion_especifica }}</td>
\t\t</tr>-->
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
\t\t{% for row in act_acc %}
\t\t\t<tr>
\t\t\t\t<td style=\"width: 20%;\" class=\"text-left\">{{ row.actividad }}</td>
\t\t\t\t<td class=\"text-left\">{{ row.unidad_medida }}</td>
\t\t\t\t<td class=\"text-left\">{{ row.medio_verificacion }}</td>
\t\t\t\t<td>{{ row.trimestre_ii }}</td>
\t\t\t\t<td>{{ row.ii }}</td>
\t\t\t\t<td>{{ row.porcentaje }}%</td>
\t\t\t</tr>
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
</html>", "gestion/pdf/accion_centralizada/II.twig", "/var/www/html/sapp/application/views/gestion/pdf/accion_centralizada/II.twig");
    }
}
