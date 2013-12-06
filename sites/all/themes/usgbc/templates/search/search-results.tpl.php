<?php

/**
 * @file search-results.tpl.php
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependant to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $type: The type of search, e.g., "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 */
?>
<div class="search-report aside hidden">
                    <span><strong><?php print $GLOBALS['pager_total_items'][0];?></strong> results for <strong><?php print search_get_keys(); ?></strong>.</span>                        
                </div>
<div class="ag-header">
<?php print $pager; ?>
 </div>

 <?php print usgbc_glossary_search_results(search_get_keys());?>

<div id="search-results" class="search-results <?php print $type; ?>-results">
  <?php print $search_results; ?>
</div>
<div class="search-results-footer">
<?php print $pager; ?>
</div>
