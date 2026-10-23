const assignmentButton = document.getElementById('assignmentButton');
const assignmentForm = document.getElementById('assignmentForm');
const cancelAssignment = document.getElementById('cancelAssignment');

assignmentButton?.addEventListener('click', () => {
    assignmentForm?.classList.toggle('hidden');
});

cancelAssignment?.addEventListener('click', () => {
    assignmentForm?.classList.add('hidden');
});

const priorityButton = document.getElementById('priorityButton');
const priorityForm = document.getElementById('priorityForm');
const cancelPriority = document.getElementById('cancelPriority');

priorityButton?.addEventListener('click', () => {
    priorityForm?.classList.toggle('hidden');
});

cancelPriority?.addEventListener('click', () => {
    priorityForm?.classList.add('hidden');
});

const internalNoteButton = document.getElementById('internalNoteButton');
const internalNoteForm = document.getElementById('internalNoteForm');
const cancelInternalNote = document.getElementById('cancelInternalNote');
const internalNoteBody = document.getElementById('body');

internalNoteButton?.addEventListener('click', () => {
    internalNoteForm?.classList.remove('hidden');
    internalNoteButton.classList.add('hidden');
    internalNoteBody?.focus();
});

cancelInternalNote?.addEventListener('click', () => {
    internalNoteForm?.classList.add('hidden');
    internalNoteButton?.classList.remove('hidden');
});
