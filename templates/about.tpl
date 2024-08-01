{include 'common/html-head.tpl'}
<div class="container">
    {include 'common/header.tpl'}
    {include 'common/nav-tabs.tpl'}
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="about" role="tabpanel" aria-labelledby="about-tab">
      <div id="about-tab">

        <p>
          This dasboard is made in collaboration of
          <a href="https://www.deutsche-digitale-bibliothek.de/" about="_blank">Deutchse Digitale Bibliothek</a> (DDB) and
          <a href="https://gwdg.de" about="_blank">Gesellschaft für wissenschaftliche Datenverarbeitung mbH Göttingen</a>
          (GWDG). Participants: Francesca Schulze (DDB), Cosmina Berta (DDB), Stefanie Rühle (DDB),
          Julianne Stiller (Grenzenlos Digital e.V.), Péter Király (GWDG).
        </p>

        <p>This is an open source project. You can find the code at:</p>
        <ul>
          <li><a href="https://github.com/pkiraly/metadata-qa-api" target="_blank">Metadata Quality Assessment Framework</a></li>
          <li><a href="https://github.com/pkiraly/metadata-qa-ddb" target="_blank">custom DDB assessments (Java)</a></li>
          <li><a href="https://github.com/pkiraly/metadata-qa-ddb-web" target="_blank">web UI (PHP)</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
{include 'common/html-footer.tpl'}