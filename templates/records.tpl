{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="factors" role="tabpanel" aria-labelledby="factors-tab">
      {assign var="max" value=(($page+1) * $limit)}
      <h2>
        Record IDs ({($page * $limit) + 1}&mdash;{if ($max < $recordCount)}{$max}{else}{$recordCount}{/if})
      </h2>

      <p>criteria:
        {if ($type == 'score')}
          {$factors[$factor]->description} = {$value}<br/>
        {else}
          {$factors[$factor]->description} = {if $value == "1"}passed{elseif $value == "0"}failed{else}{$value}{/if}<br/>
        {/if}
        {$recordCount} records
      </p>
      <ol start="{($page * $limit) + 1}">
        {foreach $recordIds as $row}
          <li><a href="?&tab=record&id={$row['recordId']}&{$controller->getCommonUrlParameters()}">{$row['recordId']}</a> ({$row['metadata_schema']}, from {$row['provider_name']})</li>
        {/foreach}
      </ol>

      {if ceil($recordCount / $limit) > 1}
        <p>
          paging:
          {for $i=0; $i<ceil($recordCount / $limit); $i++}
            {if $i != $page}
              <a title="{($i * $limit) + 1}&mdash;{($i+1) * $limit}" href="?&tab=records&field={$field}&value={$value}&schema={$schema}&provider_id={$provider_id}&set_id={$set_id}&page={$i}">{$i+1}</a>
            {else}
              {$i+1}
            {/if}
          {/for}
        </p>
      {/if}
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}