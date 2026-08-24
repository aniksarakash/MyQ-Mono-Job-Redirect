# 🔧 Troubleshooting

Symptom, likely cause, fix. Work top to bottom.

| 🔍 Symptom | Likely cause | Fix |
|---|---|---|
| Nothing at all in the Log | Script not saved, or scripting still locked | Re-check [Step 1.3](03-phase-1-server-preparation.md) |
| Every job logs "No colour data" | Job Parser off or set to Basic | [Step 1.4](03-phase-1-server-preparation.md), set Standard or Enhanced |
| Colour jobs being redirected | Parser misclassifying | Switch parser to Enhanced |
| Mono jobs not redirected | `$ENFORCE` still `false`, or wrong queue name | Check both values at the top of the script |
| "NO rights" errors in Log | Rights mismatch between queues | [Step 2.4](04-phase-2-mono-queue.md), copy rights from `secure` |
| Mono jobs still showing at the IM C2010 | IM C2010 accidentally added to `secure_mono` | [Step 2.3](04-phase-2-mono-queue.md), remove it |
| Mono jobs missing at other printers | Printer list on `secure_mono` incomplete | [Step 2.3](04-phase-2-mono-queue.md), mirror `secure` exactly, minus the C2010 |
| Redirected jobs vanish after a while | Retention shorter on `secure_mono` | [Step 2.5](04-phase-2-mono-queue.md), match retention |
| Job loops between queues | Script also pasted into `secure_mono` | Clear the script from `secure_mono`, see [8.7](10-limitations.md) |
| Users get no notification | MDC not installed | Expected, see [8.4](10-limitations.md) |
| Save button greyed out | Scripting re-locked in Easy Config | Re-enable Unlock PHP Scripting, restart services, log out and in |
| Script edits have no effect | Browser session cached before the unlock | Log out of the web interface and log back in |

---

## 🧭 Diagnostic order

When you do not know which of the above applies, follow the log.

```mermaid
flowchart TD
    S(["Open MyQ Log,<br/>filter on MonoRedirect"]) --> A{"Any lines?"}
    A -->|"none"| B["Script not running<br/>→ Step 1.3, then reprint"]
    A -->|"all warnings"| C["Parser not producing data<br/>→ Step 1.4, set Enhanced"]
    A -->|"TEST MODE lines"| D["Working, but ENFORCE is false<br/>→ Phase 5 when approved"]
    A -->|"NO rights errors"| E["Rights mismatch<br/>→ Step 2.4"]
    A -->|"Moving ... lines"| F{"Job still visible<br/>at the IM C2010?"}
    F -->|"yes"| G["C2010 is in secure_mono<br/>→ Step 2.3, remove it"]
    F -->|"no"| H{"Job visible at<br/>other printers?"}
    H -->|"no"| I["secure_mono printer list<br/>incomplete → Step 2.3"]
    H -->|"yes"| J["✅ Correct behaviour"]

    style B fill:#fee2e2,stroke:#dc2626,color:#7f1d1d
    style C fill:#fef3c7,stroke:#d97706,color:#78350f
    style D fill:#f3e8ff,stroke:#9333ea,color:#4c1d95
    style E fill:#fee2e2,stroke:#dc2626,color:#7f1d1d
    style G fill:#fee2e2,stroke:#dc2626,color:#7f1d1d
    style I fill:#fef3c7,stroke:#d97706,color:#78350f
    style J fill:#dcfce7,stroke:#16a34a,color:#14532d
```

---

## 🆘 When to roll back instead of debug

Stop debugging and go to [Rollback](09-rollback.md) if any of these are true:

| Condition | Why |
|---|---|
| A job has actually gone missing | The design says jobs are never deleted. If one is, something is wrong beyond configuration. |
| Jobs are looping between queues | Users cannot collect anything while this is happening. |
| Colour jobs are being redirected in volume | The customer's colour device is now unusable for its purpose. |
| You are inside a change window that is closing | Set `$ENFORCE = false` and finish the investigation out of hours. |

---

*Next: [End user notice template](12-user-notice-template.md)*
