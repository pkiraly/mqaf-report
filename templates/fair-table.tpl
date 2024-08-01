{foreach $table as $row name="table"}
  {if isset($row['value']) && $row['value'] != 'NA'}
    {$row['value']} ({$row['frequency']}){if !$smarty.foreach.table.last}, {/if}
  {else}
    &mdash;
  {/if}
{/foreach}