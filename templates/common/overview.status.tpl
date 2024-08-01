{* params: statusCount, statusValue *}
{if $statusCount > 0}
  <a href="?&tab=records&field={$statusId}&value={$statusValue}&{$controller->getCommonUrlParameters()}">
      {$statusCount}
  </a>
{else}
    {$statusCount}
{/if}
