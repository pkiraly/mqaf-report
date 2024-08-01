{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="about" role="tabpanel" aria-labelledby="download-tab">
      <div id="download-tab">

        <h2>Download measurements as CSV files</h2>

        <h3>summary statistics</h3>
        <ul>
          {foreach from=$summaryFiles key=$file item=$info}
            <li><a href="?tab=downloader&action=csvFile&file={$file}">{$info['label']}</a> ({$info['size']})</li>
          {/foreach}
        </ul>

        <h3>quality assessment per metadata schemas</h3>
        <ul>
          {foreach from=$schemaFiles key=$file item=$info}
            <li><a href="?tab=downloader&action=csvFile&file={$file}">{$info['label']}</a> ({$info['size']})</li>
          {/foreach}
        </ul>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}