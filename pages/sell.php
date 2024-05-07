<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $db = getDatabaseConnection();
    $categories = Category::getAllCategories($db);
    $scales = Scale::getAllScales($db);
    $brands = Brand::getAllBrands($db);

    $section = new Session();
    if (!$section->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }
    
    drawHeader();
?>

<section id="sell">
  <h2>Sell an item</h2>
  <form action="../actions/upload.php" method="post" enctype="multipart/form-data">
      <div class="input-container">
          <label for="image">Upload Images</label>
          <input type="file" id="image" name="image[]" accept="image/*" multiple class="upload-btn" required>
          <div id="image-preview"></div>
      </div>
      <div class="input-container">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" placeholder="e.g. Ferrari SF90" required>
      </div>
      <div class="input-container">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" placeholder="e.g. Scale model 99% new" required></textarea>
      </div>
      <div class="input-container">
          <label for="category">Category</label>
          <select id="category" name="category" required>
          <option value="" selected disabled>Select a category</option>
            <?php foreach($categories as $category){ ?>
                <option value="<?= $category->id ?>"><?= $category->name ?></option>
            <?php } ?>
          </select>
      </div>
      <div class="input-container">
          <label for="brand">Brand</label>
          <select id="brand" name="brand" required>
              <option value="" selected disabled>Select a brand</option>
                <?php foreach($brands as $brand){ ?>
                    <option value="<?= $brand->id ?>"><?= $brand->name ?></option>
                <?php } ?>
          </select>  
      </div>
      <div class="input-container">
          <label for="scale">Scale</label>
          <select id="scale" name="scale" required>
              <option value="" selected disabled>Select a scale</option>
                <?php foreach($scales as $scale){ ?>
                    <option value="<?= $scale->id ?>"><?= $scale->name ?></option>
                <?php } ?>
          </select>  
      </div>
      <div class="input-container">
          <label for="price">Price</label>
          <input type="number" id="price" name="price" placeholder="€0.00" required>
      </div>
      <button type="upload">Upload</button>
  </form>
</section>

<?php drawFooter(); ?>
