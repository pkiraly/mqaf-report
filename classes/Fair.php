<?php

include_once 'Criterium.php';
class Fair extends BaseTab {

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);
    $smarty->assign('controller', $this);
    $frequency = $this->db->fetchAssocList($this->db->getFrequency($this->schema, $this->provider_id, $this->set_id), 'field');
    $smarty->assign('frequency', $frequency);
    $smarty->assign('variability', $this->db->fetchAssocList($this->db->getVariablitily($this->schema, $this->provider_id, $this->set_id), 'field'));
    $fair = [
      'findable' => [
        'criteria' => ['Q-1.1', 'Q-1.2', 'Q-1.3', 'Q-1.4', 'Q-2.1', 'Q-2.2', 'Q-2.3', 'Q-3.1', 'Q-6.1', 'Q-6.2', 'Q-6.3', 'Q-6.4', 'Q-6.5', 'Q-7.1', 'Q-7.2', 'Q-7.4'],
        'ranges' => [
          'poor' => ['range' => [-72.0, -30.0], 'color' => 'orange'],
          'average' => ['range' => [-27.0, -3.0], 'color' => 'orange'],
          'good' => ['range' => 0.0, 'color' => 'green']
        ],
        'blockers' => ['Q-1.1', 'Q-6.1']
      ],
      'accessible' => [
        'criteria' => ['Q-3.2', 'Q-3.4', 'Q-4.1', 'Q-4.3', 'Q-4.4', 'Q-4.5', 'Q-4.6'],
        'ranges' => [
          'poor' => ['range' => [-12.0, -3.0], 'color' => 'orange'],
          'average' => ['range' => 0.0, 'color' => 'green'],
          'good' => ['range' => [3.0, 6.0], 'color' => 'green'],
          'very good' => ['range' => [9.0, 1000.0], 'color' => 'green']
        ],
        'blockers' => ['Q-4.1']
      ],
      'interoperable' => [
        'criteria' => ['Q-1.5', 'Q-2.4', 'Q-2.5', 'Q-2.6', 'Q-3.5', 'Q-4.2', 'Q-5.2', 'Q-7.3', 'Q-7.5', 'Q-7.6', 'Q-7.7', 'Q-7.8'], // 'Q-3.6'
        'ranges' => [
          'poor' => ['range' => [-18.0, -15.0], 'color' => 'orange'],
          'average' => ['range' => [-12.0, 0.0], 'color' => 'orange'],
          'good' => ['range' => [3.0, 18.0], 'color' => 'green'],
          'very good' => ['range' => [21.0, 1000.0], 'color' => 'green']
        ],
        'blockers' => []
      ],
      'reusable' => [
        'criteria' => ['Q-3.3', 'Q-5.1', 'Q-5.3', 'Q-5.4'], //, 'Q-5.5', 'Q-5.6', 'Q-5.7'
        'ranges' => [
          'poor' => ['range' => [-6.0, -3.0], 'color' => 'orange'],
          'average' => ['range' => 0.0, 'color' => 'green'],
          'good' => ['range' => 3.0, 'color' => 'green'],
          'very good' => ['range' => 6.0, 'color' => 'green']
        ],
        'blockers' => ['Q-5.1']
      ],
    ];
    $categories = [
      'findable' => [
        'name' => 'Auffindbarkeit und Identifzierbarkeit',
        'criteria' => [
          'Q-1.1' => [
            'title' => '<strong>Datensatz-ID</strong> ist vorhanden.',
            'score' => -9, 'blocker' => 1],
          'Q-1.2' => [
            'title' => '<strong>Datensatz-ID</strong> ist eindeutig.',
            'score' => -9],
          'Q-1.3' => [
            'title' => '<strong>Datensatz-IDs</strong> für hierarchische Objekt Darstelleungen',
            'score' => -9],
          'Q-1.4' => [
            'title' => '<strong>Datensatz</strong>-ID ist unveränderlich',
            'score' => -6],
          'Q-2.1' => [
            'title' => '<strong>Datengeber-ID</strong> ist vorhanden.',
            'score' => -6],
          'Q-2.2' => [
            'title' => '<strong>Datengeber-ID</strong> ist weltweit eindeutig (stammt aus einer Normdatei)',
            'score' => -3],
          'Q-2.3' => [
            'title' => '<strong>Datengeber</strong>-ID ist unveränderlich',
            'score' => -6],
          'Q-3.1' => [
            'title' => '<strong>Bilddatei</strong> - Im gelieferten Datensatz muss eine Referenz auf eine Bilddatei vorhanden sein (entweder als Link oder als Dateiname).',
            'score' => -9],
          'Q-6.1' => [
            'title' => 'Ein <strong>Objekttitel</strong> muss für den Datensatz vorhanden sein*',
            'score' => -9, 'blocker' => 1],
          'Q-6.2' => [
            'title' => 'Der <strong>Objekttitel</strong> muss eindeutig sein.',
            'score' => -6],
          'Q-6.3' => [
            'title' => 'Der <strong>Objekttitel</strong> muss aussagekräftig sein.',
            'score' => -3],
          'Q-6.4' => [
            'title' => 'Der <strong>Titel</strong> muss sinntragend sein und enthält keine sinnlosen Werte.',
            'score' => -3],
          'Q-6.5' => [
            'title' => 'Der <strong>Objekttitel</strong> muss eindeutig sein und darf nicht mit dem Objekttyp identisch sein.',
            'score' => -3],
          'Q-7.1' => [
            'title' => 'Im Datensatz muss mindestens eine bevorzugte Bezeichnung für den <strong>Objekttyp</strong> vorhanden sein.',
            'score' => -9],
          'Q-7.2' => [
            'title' => 'Die Vorzugsbenennung für den <strong>Objekttyp</strong> muss in deutscher Sprache angegeben sein.',
            'score' => -3],
          'Q-7.4' => [
            'title' => 'Es handelt sich um eine spezifische <strong>Objekttyp</strong>-Bezeichnung und nicht um eine Objektbeschreibung oder Objektklassifizierung.',
            'score' => -3]
        ],
      ],
      'accessible' => [
        'name' => 'Zugänglichkeit',
        'criteria' => [
          'Q-3.2' => [
            'title' => '<strong>Das Vorschaubild </strong>muss explizit gekennzeichnet sein, wenn mehr als eine Bilddatei im Datensatz referenziert ist.',
            'score' => -3],
          'Q-3.4' => [
            'title' => 'Das <strong>Bild</strong> muss mindestens 800 Pixel breit und mindestens 600 Pixel hoch sein.',
            'score' => -3],
          'Q-4.1' => [
            'title' => '<strong>Link zu der Bilddatei/digitalen Objekt</strong> ist vorhanden*',
            'score' => -9, 'blocker' => 1],
          'Q-4.3' => [
            'title' => 'Der <strong>Link zur Bilddatei/ Digitalen Objekt</strong> muss valide sein.',
            'score' => -9],
          'Q-4.4' => [
            'title' => 'Der Datensatz enthält einen <strong>Link zu einer Mediendatei</strong>.',
            'score' => 6],
          'Q-4.5' => [
            'title' => 'Der Datensatz enthält einen <strong>Link zum Objekt im Kontext</strong>',
            'score' => 3],
          'Q-4.6' => [
            'title' => 'Der Datensatz enthält einen <strong>Link zum Objekt im Medienviewer</strong>',
            'score' => 3]
        ],
      ],
      'interoperable' => [
        'name' => 'Interoperabilität und Maschinenlesbarkeit',
        'criteria' => [
          'Q-1.5' => [
            'title' => 'Der <strong>Datensatz-ID</strong> ist maschinell gut zu verarbeiten',
            'score' => 3],
          'Q-2.4' => [
            'title' => '<strong>Datengeber</strong>-ID- Der Datengeber soll durch einen International Standard Identifier for Libraries and Related Organisations (ISIL) identifiziert sein.',
            'score' => 3],
          'Q-2.5' => [
            'title' => 'Der <strong>Datengeber-ID</strong> soll durch einen http-URI aus der ISIL-Registrierung referenziert sein.',
            'score' => 6],
          'Q-2.6' => [
            'title' => '<strong>Der Datengeber</strong> kann durch einen http-URI aus der GND identifiziert sein',
            'score' => 3],
          'Q-3.5' => [
            'title' => 'Link zum <strong>Vorschaubild ist vorhanden</strong>.',
            'score' => 3],
          /*
          'Q-3.6' => [
            'title' => '<strong>Die Bilddatei</strong> soll in einem bevorzugten Format geliefert werden',
            'score' => 3],
          */
          'Q-4.2' => [
            'title' => '<strong>Bilddateien</strong> müssen in einem von der DDB unterstützten Format geliefert werden',
            'score' => -3],
          'Q-5.2' => [
            'title' => 'Die <strong>Lizenz</strong> muss durch einen http-URI gekennzeichnet sein, der im Lizenzkorb der Deutschen Digitalen Bibliothek genannt ist',
            'score' => -9],
          'Q-7.3' => [
            'title' => 'Der <strong>Objekttyp</strong> muss aus einem kontrollierten Vokabular stammen',
            'score' => -6],
          'Q-7.5' => [
            'title' => 'Der <strong>Objekttyp</strong> stammt aus der Gemeinsamen Normdatei (GND) oder dem Art &amp; Architecture Thesaurus (AAT).',
            'score' => 6],
          'Q-7.6' => [
            'title' => 'Der <strong>Objekttyp</strong> ist durch einen http-URI aus einem LOD-Vokabular referenziert',
            'score' => 6],
          'Q-7.7' => [
            'title' => 'Der http-URI für den <strong>Objekttyp</strong> verweist auf einen Begriff in der GND oder dem AAT.',
            'score' => 9],
          'Q-7.8' => [
            'title' => 'Der <strong>Objekttyp</strong> http-URI verweist auf einen Begriff in Wikidata',
            'score' => 6]
        ],
      ],
      'reusable' => [
        'name' => 'Wiederverwendbarkeit',
        'criteria' => [
          'Q-3.3' => [
            'title' => 'Der <strong>Link zur Bilddatei</strong> muss valide sein.',
            'score' => -3],
          'Q-5.1' => [
            'title' => 'Im Datensatz muss eine <strong>Lizenz</strong> für das Digitale Objekt angegeben sein',
            'score' => -9, 'blocker' => 1],
          'Q-5.3' => [
            'title' => 'Der <strong>Rechtsstatus</strong> muss für jede Mediendatei, die im Datensatz referenziert, angegeben sein.',
            'score' => -3],
          'Q-5.4' => [
            'title' => 'Es wird eine <strong>offene Lizenz</strong> für den Rechtsstatus verwendet',
            'score' => 6],
          /*
          'Q-5.5' => [
            'title' => 'Es wird eine <strong>offene Lizenz mit Namensnennung</strong> verwendet',
            'score' => 3],
          'Q-5.6' => [
            'title' => '<strong>Lizenz</strong> - Es wird ein standardisierter Rechtehinweis verwendet. Das Digitale Objekt darf mit Einschränkungen genutzt werden.',
            'score' => 0],
          'Q-5.7' => [
            'title' => '<strong>Lizenz</strong>: Es wird ein standardisierter Rechtehinweis verwendet. Die Nutzungsrechte müssen erfragt werden',
            'score' => 0]
          */
        ],
      ]
    ];
    $smarty->assign('categories', $categories);
    $values = $this->createCriteria($frequency, $categories);
    $smarty->assign('values', $this->createCriteria($frequency, $categories));
    $smarty->assign('categoryCount', $this->calculateCategoryCount($categories, $values));

    $blocked = [];
    $colors = [];
    foreach ($fair as $category => $definition) {
      $label = '';
      $color = '';
      $total = 0.0;
      foreach ($definition['blockers'] as $blocker) {
        $key = $blocker . ':score';
        if (isset($frequency[$key])) {
          foreach ($frequency[$key] as $value) {
            if ($value['value'] < 0.0) {
              $label = 'blocked';
              $color = 'red';
              $blocked[$blocker] = TRUE;
              $colors[$blocker] = $color;
            }
          }
        }
      }

      foreach ($definition['criteria'] as $Q) {
        if (isset($means[$Q]) && $means[$Q] != '&mdash;' && !isset($colors[$Q])) {
          list($l, $c) = $this->getLabel((float) $means[$Q], $definition['ranges']);
          $colors[$Q] = $c;
        }
      }

      if ($label == '') {
        foreach ($definition['criteria'] as $Q) {
          if (isset($means[$Q]) && $means[$Q] != '&mdash;') {
            $total += (float) $means[$Q];
          }
        }
        list($label, $color) = $this->getLabel($total, $definition['ranges']);
      }
      error_log($category . ': ' . $total . ' - ' . $label);
      $fair[$category] = [
        'total' => $total,
        'label' => $label,
        'color' => $color,
      ];
    }
    $smarty->assign('fair', $fair);
    $smarty->assign('blocked', $blocked);
    $smarty->assign('colors', $colors);

    $categoryCount = 0;
    $total = 0;
    $not_measured = 0;
    foreach ($frequency['ruleCatalog:score'] as $record) {
      if (!is_null($record['value']) && $record['value'] != 'NA') {
        $categoryCount += $record['frequency'];
        $total += ($record['frequency'] * $record['value']);
      } else {
        $not_measured += $record['frequency'];
      }
    }
    $smarty->assign('totalScore', $total / $categoryCount);
    $smarty->assign('notMeasured', $not_measured);
  }

  public function getTemplate() {
    return 'fair.tpl';
  }

  private function getLabel($score, $ranges) {
    $label = '';
    $color = '';
    if ($score < 0) {
      $label = 'To be improved';
      $color = 'orange';
    } else if ($score == 0) {
      $label = 'Acceptable'; $color = '';
    } else if ($score > 0) {
      $label = 'Good'; $color = 'green';
    }
    /*
    foreach ($ranges as $_label => $range) {
      if (is_array($range['range'])) {
        if ($range['range'][0] <= $score && $range['range'][1] >= $score) {
          $label = $_label;
        }
      } else {
        if ($score == $range['range']) {
          $label = $_label;
        }
      }
      if ($label != '') {
        $color = $range['color'];
        break;
      }
    }
    */
    return [$label, $color];
  }

  private function createCriteria($frequency, $categories) {
    $index = [];
    foreach ($categories as $name => $category) {
      foreach (array_keys($category['criteria']) as $Q) {
        $index[$Q] = $name;
      }
    }

    $criteria = [];
    foreach ($frequency as $key => $values) {
      if (preg_match('/^(Q.*):(score|status)$/', $key, $matches)) {
        $criteria[$matches[1]][$matches[2]] = $values;
      }
    }

    foreach ($criteria as $id => $item) {
      $category = $index[$id];
      $criteria_definition = $categories[$category]['criteria'][$id];
      $criteria[$id] = new Criterium($id, $category, $criteria_definition, $item['status'], $item['score']);
    }

    return $criteria;
  }

  private function calculateCategoryCount($categories, $values) {
    $categoryCount = [];
    foreach ($categories as $id => $category) {
      $total = 0;
      foreach ($category['criteria'] as $critId => $critDef) {
        $dao = $values[$critId];
        if ($dao->isMeasured()) {
          $total++;
          foreach ($dao->getDistribution() as $color => $frequency) {
            if (!isset($categoryCount[$id][$color]))
              $categoryCount[$id][$color] = 0;
            $categoryCount[$id][$color] += ($frequency * 100 / $this->count);
          }
        }
      }
      foreach ($categoryCount[$id] as $color => $percent) {
        $categoryCount[$id][$color] = [
          'raw' => ceil($percent * 4 / $total),
          'formatted' => sprintf("%.1f%%", $percent / $total)
        ];
      }
    }
    return $categoryCount;
  }
}