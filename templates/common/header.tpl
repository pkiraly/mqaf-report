<h1 style="text-align: right">
  <a href="." class="header-link"><img src="{$host}/styles/aqinda-logo.png" class="hidden-xs hidden-sm" width="400"></a>
  <i class="fa fa-cogs" aria-hidden="true"></i> <span>{_('metadata quality assessment dashboard')}</span>
</h1>

<diw class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <i class="fa fa-book" aria-hidden="true"></i>
    <span class="header-info">
      {if $lastUpdate != ''}
       last data update: <strong>{$lastUpdate}</strong>
      {/if}
    </span>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <p style="text-align: right">
      {if $lang == 'en'}English{else}<a href="?lang=en">English</a>{/if} |
      {if $lang == 'de'}Deutsch{else}<a href="?lang=de">Deutsch</a>{/if}
    </p>
  </div>
</diw>

