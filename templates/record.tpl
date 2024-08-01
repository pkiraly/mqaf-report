{include 'common/html-head.tpl'}
<div class="container">
  {include 'common/header.tpl'}
  {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="record" role="tabpanel" aria-labelledby="factors-tab">
      <h2>Record view {if (isset($id) && !empty($id))}<span>{$id}</span>{/if}</h2>

      {if (!isset($id) || empty($id))}
        <p>No record identifier has been given.</p>
      {elseif (!isset($record) || empty($record))}
        <p>This record does not exist. Type in a complete record number!</p>
      {else}

        <ul>
          <li>metadata schema: {$filedata['metadata_schema']}</li>
          <li>provider: {$filedata['provider_name']}</li>
          <li>dataset name: {$filedata['set_name']}</li>
          <li>file: {$filedata['file']}</li>
          <li>last modified: {$filedata['datum']}</li>
          <li>file size: {$filedata['size']}</li>
        </ul>

        <table>
          {foreach $issues as $id => $value}
            {if $id != 'recordId' && $id != 'providerid'}
              <tr>
                <td>{$id}</td>
                <td>
                  {if isset($factors[$id])}
                    {$factors[$id]->description}
                    {if isset($factors[$id]->criterium)}
                      <em title='{str_replace('|', "\n", $factors[$id]->criterium)}'><i class="fa fa-question"></i></em>
                    {/if}
                  {/if}
                </td>
                {if isset($value['status'])}
                  <td class="result {if $value['status'] == "1"}passed{elseif $value['status'] == "0"}failed{else}{$value['status']}{/if}">
                    {if $value['status'] == "1"}passed{elseif $value['status'] == "0"}failed{else}{$value['status']}{/if}
                  </td>
                {else}
                  <td></td>
                {/if}
                <td class="result">
                  {if isset($value['score'])}
                    {$value['score']}
                    {if isset($factors[$id]->scoring)}
                      <em title='{$factors[$id]->scoring}'><i class="fa fa-question"></i></em>
                    {/if}
                  {/if}
                </td>
              </tr>
            {/if}
          {/foreach}
        </table>

        <xmp>{$record}</xmp>
        <p>
          <a href="?tab=downloader&action=downloadRecord&id={$id}">download record</a>
          &mdash;
          <a href="?tab=downloader&action=downloadFile&id={$id}">download file</a>
        </p>

      {/if}
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}