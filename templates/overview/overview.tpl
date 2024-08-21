<h3>{$count} records</h3>
{include 'common/data-source-statistics.tpl'}

{include 'overview/schemaConfiguration.tpl'}

<p>average score: <strong>{sprintf("%.2f", $totalScore)}</strong> (not measured: {$notMeasured} records)</p>
{if isset($frequency['ruleCatalog:score'])}
  <table class="values">
    <caption>score distribution</caption>
    <tr>
      <td class="">score</td>
      {foreach $frequency['ruleCatalog:score'] as $record name="records"}
        {if !is_null($record['value']) && $record['value'] != 'NA'}
          <td class="value">
            <a href="?&tab=records&field=ruleCatalog:score&value={$record['value']}&{$controller->getCommonUrlParameters()}">
              {$record['value']}
            </a>
          </td>
        {/if}
     {/foreach}
    </tr>
    <tr>
      <td class="">records</td>
      {foreach $frequency['ruleCatalog:score'] as $record name="records"}
        {if !is_null($record['value']) && $record['value'] != 'NA'}
          <td class="frequency">{$record['frequency']}</td>
        {/if}
      {/foreach}
    </tr>
  </table>
{/if}

{include 'overview/criteria-statistics.tpl'}
{* include 'overview/fixed-criteria.tpl' *}

<p>
  Criteria that are not yet implemented, or not applicable to a particular metadata schema,
  are <span style="color: #cccccc;">greyed out</span>
</p>

