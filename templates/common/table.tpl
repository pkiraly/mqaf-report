<h3>{$filename}: {$count} records</h3>
<p><a href="?tab=downloader&action=downloadFile&subdir={$subdir}">download file</a></p>
<table id="criteria-table">
  <thead>
  <tr>
    <th colspan="2">criterium</th>
    <th>score</th>
    <th>status</th>
  </tr>
  </thead>
  <tbody>
    {foreach $factors as $id => $factor}
      {if $id != 'file'}
        <tr class="{if $factor->isGroup}criteria-group{else}criterium{/if}">
          <td class="id">{$id}</td>
          <td style="width: 600px">{$factor->description}</td>
          <td>
            {assign var="scoreId" value={$id|cat:':score'}}
            {if isset($frequency[$scoreId])}
              <table class="values">
                {foreach $frequency[$scoreId] as $record name="records"}
                  <tr>
                    <td class="value">
                      <a href="?subdir={$subdir}&tab=records&field={$scoreId}&value={$record->value}">
                        {$record->value}
                      </a>
                    </td>
                    <td class="frequency">{$record->frequency}</td>
                  </tr>
                {/foreach}
              </table>
            {/if}
          </td>
          <td>
            {assign var="statusId" value={$id|cat:':status'}}
            {if isset($frequency[$statusId])}
                  {assign var="passed" value=0}
                  {assign var="failed" value=0}
                  {assign var="NA" value=0}
                  {foreach $frequency[$statusId] as $record name="records"}
                      {if $record->value == "1"}
                          {assign var="passed" value=$record->frequency}
                      {elseif $record->value == "0"}
                          {assign var="failed" value=$record->frequency}
                      {elseif $record->value == "NA"}
                          {assign var="NA" value=$record->frequency}
                      {/if}
                  {/foreach}
              <table class="values">
                <tr>
                  <td class="bar width50">{$passed}</td>
                  <td class="bar width50">{$failed}</td>
                  <td class="bar width50">{$NA}</td>
                </tr>
                <tr>
                  <td class="bar green width50"><div style="width: {ceil(50 * $passed / $count)}px">&nbsp;</div></td>
                  <td class="bar red width50"><div style="width: {ceil(50 * $failed / $count)}px">&nbsp;</div></td>
                  <td class="bar grey width50"><div style="width: {ceil(50 * $NA / $count)}px">&nbsp;</div></td>
                </tr>
              </table>
            {/if}
          </td>
        </tr>
      {/if}
    {/foreach}
  </tbody>
</table>
