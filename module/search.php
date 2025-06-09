
<link rel="stylesheet" href="module/css2/search.css">



<h1>Search</h1>

<form action="/search" method="get" role="search" class="search">
  <div class="field">
    <input
      type="search"
      name="q"
      class="search__input field__input"
      id="search-input"
      placeholder="Search"
      aria-label="Search"
      autocomplete="off"
      spellcheck="false"
    />
    <label for="search-input" class="field__label">Search</label>

    <input type="hidden" name="options[prefix]" value="last" />

    <!-- Tombol reset -->
    <button type="reset" class="reset__button field__button" aria-label="Clear search term">
      <svg class="icon icon-close" aria-hidden="true" focusable="false">
        <use xlink:href="#icon-reset"></use>
      </svg>
    </button>

    <!-- Tombol submit -->
    <button type="submit" class="search__button field__button" aria-label="Search">
      <svg class="icon icon-search" aria-hidden="true" focusable="false">
        <use xlink:href="#icon-search"></use>
      </svg>
    </button>
  </div>
</form>
