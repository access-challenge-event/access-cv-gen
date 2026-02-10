<?php
/**
 * Reusable Bootstrap 5 Modal Component
 *
 * Usage:
 *   <?php render_modal([
 *       'id'            => 'deleteEducationModal',        // Required – unique modal ID
 *       'title'         => 'Delete Education',            // Modal header title
 *       'body'          => 'Are you sure you want to delete this education entry?',
 *       'confirmText'   => 'Delete',                      // Confirm button label  (default: "Confirm")
 *       'cancelText'    => 'Cancel',                      // Cancel button label   (default: "Cancel")
 *       'confirmClass'  => 'btn-danger',                  // Confirm button class  (default: "btn-primary")
 *       'confirmAction' => '/api/education/delete',       // Optional form action URL (POST)
 *       'size'          => 'modal-sm',                    // Optional: modal-sm | modal-lg | modal-xl
 *       'centered'      => true,                          // Vertically centred    (default: true)
 *       'static'        => false,                         // Static backdrop       (default: false)
 *   ]); ?>
 *
 * Trigger example:
 *   <button data-bs-toggle="modal" data-bs-target="#deleteEducationModal">Delete</button>
 *
 * JavaScript helpers (included automatically once):
 *   // Set a hidden input value before the modal opens
 *   setModalData('deleteEducationModal', 'itemId', 42);
 *
 *   // Update the modal body text dynamically
 *   setModalBody('deleteEducationModal', 'Delete "BSc Computer Science"?');
 */

function render_modal(array $options): void {
    $id           = $options['id']            ?? 'confirmModal';
    $title        = $options['title']         ?? 'Confirm';
    $body         = $options['body']          ?? 'Are you sure?';
    $confirmText  = $options['confirmText']   ?? 'Confirm';
    $cancelText   = $options['cancelText']    ?? 'Cancel';
    $confirmClass = $options['confirmClass']  ?? 'btn-primary';
    $confirmAction = $options['confirmAction'] ?? '';
    $size         = isset($options['size']) ? ' ' . $options['size'] : '';
    $centered     = ($options['centered'] ?? true) ? ' modal-dialog-centered' : '';
    $static       = ($options['static'] ?? false);
    $backdropAttr = $static ? ' data-bs-backdrop="static" data-bs-keyboard="false"' : '';
?>
<div class="modal fade" id="<?= htmlspecialchars($id) ?>" tabindex="-1" aria-labelledby="<?= htmlspecialchars($id) ?>Label" aria-hidden="true"<?= $backdropAttr ?>>
    <div class="modal-dialog<?= $centered . $size ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?= htmlspecialchars($id) ?>Label"><?= htmlspecialchars($title) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php if ($confirmAction): ?>
            <form method="POST" action="<?= htmlspecialchars($confirmAction) ?>">
            <?php endif; ?>
                <div class="modal-body" id="<?= htmlspecialchars($id) ?>Body">
                    <?= $body /* Allow HTML in body */ ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= htmlspecialchars($cancelText) ?></button>
                    <?php if ($confirmAction): ?>
                        <button type="submit" class="btn <?= htmlspecialchars($confirmClass) ?>"><?= htmlspecialchars($confirmText) ?></button>
                    <?php else: ?>
                        <button type="button" class="btn <?= htmlspecialchars($confirmClass) ?>" id="<?= htmlspecialchars($id) ?>Confirm"><?= htmlspecialchars($confirmText) ?></button>
                    <?php endif; ?>
                </div>
            <?php if ($confirmAction): ?>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
    // Include JS helpers once
    static $jsIncluded = false;
    if (!$jsIncluded) {
        $jsIncluded = true;
?>
<script>
/**
 * Add or update a hidden input inside a modal's form.
 * Useful for passing dynamic data (e.g. an item ID) before confirming.
 */
function setModalData(modalId, name, value) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    let input = modal.querySelector('input[name="' + name + '"]');
    if (!input) {
        input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        const form = modal.querySelector('form');
        if (form) {
            form.appendChild(input);
        } else {
            modal.querySelector('.modal-body').appendChild(input);
        }
    }
    input.value = value;
}

/**
 * Update the body content of a modal dynamically.
 */
function setModalBody(modalId, html) {
    const body = document.getElementById(modalId + 'Body');
    if (body) body.innerHTML = html;
}
</script>
<?php
    }
}
