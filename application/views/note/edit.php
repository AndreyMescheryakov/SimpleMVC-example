<style> 
    
    textarea{
        height: 50%;
        width: 1000px;
        color: #003300;
    }
   
</style>

<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;
use application\models\Category;
use application\models\Subcategory;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');

// Получаем все категории для выпадающего списка
$categoryModel = new Category();
$categories = $categoryModel->getList(100)['results'];

// Получаем подкатегории для выбранной категории (если есть)
$subcategories = [];
if ($viewNotes->categoryId) {
    $subcategoryModel = new Subcategory();
    $sql = "SELECT * FROM subcategories WHERE categoryId = :categoryId ORDER BY name";
    $st = $subcategoryModel->pdo->prepare($sql);
    $st->bindValue(":categoryId", $viewNotes->categoryId, \PDO::PARAM_INT);
    $st->execute();
    $subcategories = $st->fetchAll(\PDO::FETCH_OBJ);
}
?>

<?php include('includes/admin-notes-nav.php'); ?>

<h2><?= $editNoteTitle ?></h2>

<form id="editNote" method="post" action="<?= $Url::link("admin/notes/edit&id=" . $_GET['id'])?>">
    
    <h5>Заголовок статьи</h5> 
    <input type="text" name="title" placeholder="Название статьи" value="<?= htmlspecialchars($viewNotes->title) ?>"><br>
    
    <h5>Категория</h5>
    <select name="categoryId" id="categoryId">
        <option value="">-- Без категории --</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->id ?>" 
                <?= ($viewNotes->categoryId == $category->id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($category->name) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    
    <h5>Подкатегория</h5>
    <select name="subcategoryId" id="subcategoryId">
        <option value="">-- Без подкатегории --</option>
        <?php foreach ($subcategories as $subcategory): ?>
            <option value="<?= $subcategory->id ?>" 
                <?= ($viewNotes->subcategoryId == $subcategory->id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($subcategory->name) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    
    <h5>Содержание статьи</h5>
    <textarea name="content" placeholder="Текст статьи"><?= htmlspecialchars($viewNotes->content) ?></textarea><br>

    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    <input type="submit" name="saveChanges" value="Сохранить">
    <input type="submit" name="cancel" value="Назад">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var categorySelect = document.getElementById('categoryId');
    var subcategorySelect = document.getElementById('subcategoryId');
    
    function loadSubcategories(categoryId) {
        // Очищаем и добавляем опцию по умолчанию
        subcategorySelect.innerHTML = '<option value="">-- Без подкатегории --</option>';
        
        if (!categoryId) return;
        
        // Простой запрос к нашей функции
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= WebRouter::link("admin/notes/getSubcategories&categoryId=") ?>' + categoryId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var subcategories = JSON.parse(xhr.responseText);
                    subcategories.forEach(function(subcat) {
                        var option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.name;
                        // Выбираем текущую подкатегорию статьи
                        if (subcat.id == <?= $viewNotes->subcategoryId ?? 'null' ?>) {
                            option.selected = true;
                        }
                        subcategorySelect.appendChild(option);
                    });
                } catch(e) {
                    console.error('Error parsing JSON:', e);
                }
            }
        };
        xhr.send();
    }
    
    // Загружаем подкатегории при загрузке страницы (если категория уже выбрана)
    if (categorySelect.value) {
        loadSubcategories(categorySelect.value);
    }
    
    // Загружаем при изменении категории
    categorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });
});
</script>