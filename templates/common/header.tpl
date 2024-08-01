<p>
  <a href="." class="header-link"><img src="https://www.deutsche-digitale-bibliothek.de/assets/DDB_Logo_RGB_Reduziert_Claim-a18eb91420ebf3d4531c194d99ad972f.png"
                                       class="hidden-xs hidden-sm"></a>
</p>
<h1 style="text-align: right">
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

