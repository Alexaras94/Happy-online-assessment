# Design Decisions & Challenges

## 🏗 Architecture: Repository–Service Pattern

For this application, I implemented the **Repository–Service Pattern** together with **Data Transfer Objects (DTOs)**.

### Why this pattern?

#### ✔ Separation of Concerns
- **Controllers** handle HTTP requests, validation, and formatting responses.
- **Services** contain the business logic (e.g., generating slugs, dispatching events).
- **Repositories** handle database queries and Eloquent operations.

#### ✔ Maintainability
Extracting logic out of controllers keeps the code clean and easier to test.

#### ✔ Type Safety
DTOs ensure that data passed between layers is structured and predictable instead of relying on loose associative arrays.

---

## 🧩 Key Design Choices

### 1. Data Transfer Objects (DTOs)

I used the concepts of the `spatie/laravel-data` package to create strict DTOs such as **PostDTO** and **FilterDTO**.

**Benefits:**
- No "magic string" issues.
- Strong structure between the controller → service → repository flow.
- Predictable and typed input.

---

### 2. API Resources

To ensure consistent JSON responses, I used **Laravel API Resources**.

**Benefit:**  
Models are transformed before being returned, allowing:
- Field renaming
- Hiding internal IDs
- Flattening relationships

**Example:**  
`PostResource` reduces the `author` relationship to only return the author's name and email.

---

### 3. Event-Driven Logic

For sending email notifications when a comment is created, I used **Events & Listeners**.

**Why:**  
The `CommentService` should not know how emails work. It only triggers an event:

> “A comment was created.”

A Listener handles the actual notification.

**Benefit:**  
Decoupled logic — easier maintenance, easier testing.

---

### 4. Observers for Auto-Tagging

Auto-tagging posts as **"new"** on create and **"edited"** on update was implemented via a `PostObserver`.

**Benefit:**
- Controllers stay clean.
- Tagging rules apply everywhe
