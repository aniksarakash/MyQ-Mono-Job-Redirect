# 📖 References

Every property and method used in [`../src/mono-redirect.php`](../src/mono-redirect.php) traces back to official MyQ X 10.2 documentation.

---

## 🔗 Primary source

**[PHP Scripts Actions Examples, MyQ X 10.2](https://docs.myq-solution.com/en/myq-x/10.2/print-server/php-scripts-actions-examples)**

That page is the canonical set of building blocks for queue level job scripting. It documents actions based on page count, job size, paper format, job owner, duplex property, colour property, job name or source application, rights to a queue, group membership, and the job's PDL, plus custom log messages and three complex composed examples.

This project is a composition of three of those documented patterns:

| Documented pattern | Used here as |
|---|---|
| Actions based on the colour property, `if ($this->color)` | Branch 2, colour jobs stay on `secure` |
| Actions based on rights to a queue, `canPrintToQueue()` | Branch 4, pre-check before moving |
| Conditional move with notification fallback | Branch 5, notify then `moveToQueue()` |

---

## 🔗 Related MyQ pages

| Page | Relevance |
|---|---|
| [Job Scripting](https://docs.myq-solution.com/en/myq-x/10.2/print-server/job-scripting) | Where scripting sits in the queue processing pipeline |
| [Job Processor Scripting](https://docs.myq-solution.com/en/myq-x/10.2/print-server/job-processor-scripting) | The "Actions after processing" field this script goes into |
| [Job Scripting Reference](https://docs.myq-solution.com/en/myq-x/10.2/print-server/job-scripting-reference) | Full property and method reference |
| [User Interaction Scripting](https://docs.myq-solution.com/en/myq-x/10.2/print-server/user-interaction-scripting) | Terminal side prompts, not used in this design |

---

## 🧾 API surface, mapped to documentation

### Job object, `$this`

| Used here | Documented on the examples page |
|---|:---:|
| `$this->name` | ✅ shown with `strpos($this->name, ...)` |
| `$this->color` | ✅ shown as `if ($this->color)` |
| `$this->colorCount` | ✅ shown as `if ($this->colorCount > 20)` |
| `$this->monoCount` | ⬜ logged only, counterpart to `colorCount` |
| `$this->pageCount` | ✅ shown as `if ($this->pageCount > 500)` |
| `$this->queue->name` | ⬜ logged only |
| `$this->owner` | ✅ documented, and assignable |
| `$this->moveToQueue("name")` | ✅ the central documented action |
| `$this->name = "..."` | ⬜ used in the optional rename snippet |

Other documented job properties this design does not use: `dataSize`, `paper`, `duplex`, `copies`, `lang`. `$this->delete()` is documented and deliberately **not** used here, because jobs must never be destroyed.

### User object, `$this->owner`

| Used here | Documented |
|---|:---:|
| `$owner->name` | ✅ |
| `$owner->canPrintToQueue("secure_mono")` | ✅ shown as `canPrintToQueue("Color")` |
| `$owner->sendNotification($level, $title, $body)` | ✅ shown as `sendNotification("error", "Job refused", ...)` |
| `$owner->sendEmail($subject, $body)` | ✅ shown as `sendEmail("Job error", ...)` |

Also documented and available for [limitation 8.2](10-limitations.md) if per group behaviour is ever needed: `$owner->hasGroup("Clerks")` and `$owner->personalQueues`.

### MyQ helper

| Used here | Documented |
|---|:---:|
| `MyQ()->logInfo()` | ✅ shown as a custom log message |
| `MyQ()->logNotice()` | ⬜ same family as `logInfo` |
| `MyQ()->logWarning()` | ⬜ same family as `logInfo` |
| `MyQ()->logError()` | ⬜ same family as `logInfo` |

`MyQ()->getUserByUserName()` is documented and not needed here, because the job already carries its owner.

---

## 🔐 Security control

**Unlock PHP Scripting** in Easy Config exists because of **CVE-2024-22076**, a MyQ Print Server vulnerability in the job scripting path. The field is read-only by default for that reason.

Unlock it for deployment, and switch it back off in [Phase 6](08-phase-6-closeout.md). The script continues to run while locked. Only editing is blocked.

---

## 📸 Screenshots in this repository

Captured from the reference deployment on MyQ X 10.2.

| File | Shows |
|---|---|
| [`assets/01-easy-config-unlock-php-scripting.png`](assets/01-easy-config-unlock-php-scripting.png) | Easy Config, Security tab, with Unlock PHP Scripting enabled |
| [`assets/02-queues-secure-and-secure-mono.png`](assets/02-queues-secure-and-secure-mono.png) | Queues list, both Pull Print queues side by side with their printer counts |
| [`assets/03-job-processing-scripting-php.png`](assets/03-job-processing-scripting-php.png) | The `secure` queue, Job Processing tab, script in the Actions after processing field |

---

*Back to the [runbook index](README.md)*
