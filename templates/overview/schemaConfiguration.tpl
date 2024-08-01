<h4>{_('Schema configuration')}</h4>

<ul>
  <li>format: {$schemaConfiguration['format']}</li>
  <li>fields:
    <ul>
      {foreach $schemaConfiguration['fields'] as $field}
        {if (isset($field['extractable']) && $field['extractable'] === TRUE) || isset($field['rules'])}
          <li>
            &nbsp; {$field['name']}
            {if (isset($field['extractable']) && $field['extractable'] === TRUE)}(extractable){/if}
            {if isset($field['rules'])}
              <br/>&nbsp; rules:
              <ul>
                {foreach $field['rules'] as $rule}
                  <li>
                    {if isset($rule['description'])}
                      &nbsp; &nbsp; {$rule['description']}
                    {elseif isset($rule['id'])}
                      &nbsp; &nbsp; {$rule['id']}
                    {/if}
                  </li>
                {/foreach}
              </ul>
            {/if}
          </li>
        {/if}
      {/foreach}
    </ul>
  </li>
</ul>