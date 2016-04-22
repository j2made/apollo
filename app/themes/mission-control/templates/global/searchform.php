<form role="search" method="get" class="search-form" action="<?= esc_url(home_url('/')); ?>">
  <label class="screen-reader-text">Search the site:</label>
  <div class="input-group">
    <input type="search" value="<?= get_search_query(); ?>" name="s" class="search-field form-control" placeholder="Search <?php bloginfo('name'); ?>" required>
    <span class="input-group-btn">
      <button type="submit" class="search-submit btn btn-search">Search</button>
    </span>
  </div>
</form>
