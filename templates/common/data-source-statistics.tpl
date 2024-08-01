<p class="data-source-statistics">
  <strong>{_('metadata schemas')}:</strong>
    {foreach $recordsBySchema as $item name="stat"}
      <a href="?tab={$tab}&schema={$item['id']}&lang={$lang}">{$item['id']}</a>
      <span>({_t('n.records', $item['count'])})</span>{if !$smarty.foreach.stat.last}, {/if}
    {/foreach}<br>
  <strong>{_('data providers')}:</strong>
    {foreach $recordsByProvider as $item name="stat"}
      <a href="?tab={$tab}&provider_id={$item['id']}&lang={$lang}">{$item['name']}</a>
      <span>({_t('n.records', $item['count'])})</span>{if !$smarty.foreach.stat.last}, {/if}
    {/foreach}<br>
  <strong>{_('datasets')}:</strong>
    {foreach $recordsBySet as $item name="stat"}
      <a href="?tab={$tab}&set_id={$item['id']}&lang={$lang}">{$item['name']}</a>
      <span>&mdash; id:{$item['id']}({_t('n.records', $item['count'])})</span>{if !$smarty.foreach.stat.last}, {/if}
    {/foreach}<br>
</p>
