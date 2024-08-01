{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="factors" role="tabpanel" aria-labelledby="factors-tab">
      <h2>FAIR assessment</h2>

      <h3>{$count} records</h3>
      {include 'common/data-source-statistics.tpl'}

      <table class="fair">
        <thead>
        <tr>
          <th style="min-width: 100px; max-width: 150px;">Kategorien für Qualitätskriterien (FAIR Prinzipien)</th>
          <th>Beschreibung</th>
          <th>Bewertungs-matrix</th>
{*
          <th>Kriterium nicht erfüllt</th>
          <th>Kriterium erfüllt</th>
*}
          <th style="width: 100px; text-align: center" class="red">Blocked</th>
          <th style="width: 100px; text-align: center" class="orange">To be improved</th>
          <th style="width: 100px; text-align: center">Acceptable</th>
          <th style="width: 100px; text-align: center" class="green">Good</th>
        </tr>
        </thead>
        <tbody>
        {foreach $categories as $name => $cat_definition}
          <tr>
            <td class="category" colspan="7">{$cat_definition['name']}</td>
          </tr>
          {foreach from=$cat_definition['criteria'] key=$id item=$criteria name="criteria"}
            {assign var="value" value=$values[$id]}
            <tr>
              {if $smarty.foreach.criteria.first}
                <td class="fair-category-result" rowspan="{count($cat_definition['criteria'])}">
                  {*
                  <div class="label {$fair[$name]['color']}">{$fair[$name]['label']}</div>
                  <span class="score">({$fair[$name]['total']})</span>
                  *}
                </td>
              {/if}
              <td class="{$value->getClass()}">{$factors[$id]->description}</td>
              <td class="text-center {$value->getClass()}">{$id}</td>
{*
              <td class="text-center {$value->getClass()}">{if $criteria['score'] < 0}{$criteria['score']}{else}0{/if}</td>
              <td class="text-center {$value->getClass()}">{if $criteria['score'] > 0}{$criteria['score']}{else}0{/if}</td>
*}
              <td class="text-center {if $value->isBlocked()}red{/if}" title="{$value->tooltip('blocked', $count)}">
                {if $value->isBlocked()}
                  <div><a href="{$value->getLink('blocked', $controller)}">{$value->percent('blocked', $count)}</a></div>
                {/if}
              </td>
              <td class="text-center orange" title="{$value->tooltip('orange', $count)}">
                {if $value->has('orange')}
                  <div><a href="{$value->getLink('orange', $controller)}">{$value->percent('orange', $count)}</a></div>
                {/if}
              </td>
              <td class="text-center white" title="{$value->tooltip('white', $count)}">
                {if $value->has('white')}
                  <div><a href="{$value->getLink('white', $controller)}">{$value->percent('white', $count)}</a></div>
                {/if}
              </td>
              <td class="text-center green" title="{$value->tooltip('green', $count)}">
                {if $value->has('green')}
                  <div><a href="{$value->getLink('green', $controller)}">{$value->percent('green', $count)}</a></div>
                {/if}
              </td>
            </tr>
          {/foreach}
          <tr>
            <td colspan="7" style="padding: 50px 0 50px 0;">
              <table style="margin: auto;">
                <tr>
                  <td colspan="4"></td>
                  {*
                    <td style="width: 100px; text-align: center"><strong>Blocked</strong></td>
                  *}
                  <td style="width: 100px; text-align: center"><strong>To be improved</strong></td>
                  <td style="width: 100px; text-align: center"><strong>Acceptable</strong></td>
                  <td style="width: 100px; text-align: center"><strong>Good</strong></td>
                </tr>
                <tr>
                  <td colspan="4" class="text-right" style="vertical-align: middle; padding-right: 10px;"><strong>Average percentage</strong></td>
                  {*
                    <td class="text-center {if isset($categoryCount[$name]['blocked'])}red{/if}">
                        {if isset($categoryCount[$name]['blocked'])}
                          <div>{$categoryCount[$name]['blocked']['formatted']}</div>
                        {/if}
                    </td>
                  *}
                  <td class="text-center orange">
                    {if isset($categoryCount[$name]['orange'])}
                      <div>{$categoryCount[$name]['orange']['formatted']}</div>
                    {/if}
                  </td>
                  <td class="text-center white">
                    {if isset($categoryCount[$name]['white'])}
                      <div>{$categoryCount[$name]['white']['formatted']}</div>
                    {/if}
                  </td>
                  <td class="text-center green">
                    {if isset($categoryCount[$name]['green'])}
                      <div>{$categoryCount[$name]['green']['formatted']}</div>
                    {/if}
                  </td>
                </tr>
              </table>

              <div class="text-center" style="margin: 30px auto 0 auto;"><strong>Zugänglichkeit</strong></div>
              <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                  <td style="width: 50%; text-align: right; padding-right: 5px; border-right: 3px solid #cccccc">
                    Good {if isset($categoryCount[$name]['green'])}({$categoryCount[$name]['green']['formatted']}){/if}
                  </td>
                  <td style="padding-left: 5px; ">
                    {if isset($categoryCount[$name]['green'])}
                      <div style="background-color: #37ba00; width: {$categoryCount[$name]['green']['raw']}px;">&nbsp;</div>
                    {/if}
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; text-align: right; padding-right: 5px; border-right: 3px solid #cccccc">
                    Acceptable {if isset($categoryCount[$name]['white'])}({$categoryCount[$name]['white']['formatted']}){/if}
                  </td>
                  <td style="padding-left: 5px; ">
                    {if isset($categoryCount[$name]['white'])}
                      <div style="background-color: #cccccc; width: {$categoryCount[$name]['white']['raw']}px;">&nbsp;</div>
                    {/if}
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%; text-align: right; padding-right: 5px; border-right: 3px solid #cccccc;">
                    {if isset($categoryCount[$name]['orange'])}
                      <div style="background-color: orange; float: right; width: {$categoryCount[$name]['orange']['raw']}px;">&nbsp;</div>
                    {/if}
                  </td>
                  <td style="padding-left: 5px; ">
                    To be improved {if isset($categoryCount[$name]['orange'])}({$categoryCount[$name]['orange']['formatted']}){/if}
                  </td>
                </tr>
                {*
                <tr>
                  <td style="width: 50%; text-align: right; padding-right: 5px; border-right: 3px solid #cccccc">
                    {if isset($categoryCount[$name]['blocked'])}
                      <div style="background-color: #d5073c; float: right; width: {$categoryCount[$name]['blocked']['raw']}px;">&nbsp;</div>
                    {/if}
                  </td>
                  <td style="padding-left: 5px; ">
                    Blocked {if isset($categoryCount[$name]['blocked'])}({$categoryCount[$name]['blocked']['formatted']}){/if}
                  </td>
                </tr>
                *}
              </table>
            </td>
          </tr>
        {/foreach}
        </tbody>
      </table>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}