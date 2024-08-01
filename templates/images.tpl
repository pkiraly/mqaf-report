{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="pareto" role="tabpanel" aria-labelledby="pareto-tab">
      <h2>Quality factors</h2>

      <p>
        datasets: {foreach $subdirs as $_subdir name='subdirs'}
          {if $_subdir != $subdir}<a href="?subdir={$_subdir}&tab={$tab}">{$_subdir}</a>{else}{$subdir}{/if}
          {if !$smarty.foreach.subdirs.last} &mdash; {/if}
        {/foreach}
      </p>

      {include 'common/table.tpl'}
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}