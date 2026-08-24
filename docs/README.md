# 📚 Deployment Runbook

**Keeping black and white jobs off the Ricoh IM C2010. Server side only, no changes to user PCs.**

| Field | Value |
|---|---|
| 🏢 Prepared by | SPSL Technical, Smart Printing Solutions Ltd. |
| 🖧 Platform | MyQ X Print Server 10.2 |
| 🖨️ Devices | Ricoh IM C2010 (colour, restricted), Ricoh IM 2500 (mono), plus existing fleet |
| 📄 Version | 2.0, server side design |
| 👤 Client | `_________________________` |
| 🔧 Engineer | `_________________________` |
| 📅 Date | `_________________________` |

---

## 🗺️ Read in this order

| # | Document | What it covers |
|---|---|---|
| 📐 | [**Objective and design**](01-design.md) | The requirement, the two queue trick, why it needs no client work |
| ☑️ | [**Pre-deployment checklist**](02-pre-deployment-checklist.md) | Ten items to confirm before you touch anything |
| 1️⃣ | [**Phase 1, server preparation**](03-phase-1-server-preparation.md) | Licence, backup, unlock scripting, Job Parser |
| 2️⃣ | [**Phase 2, mono landing queue**](04-phase-2-mono-queue.md) | Create `secure_mono`, printers, rights, retention |
| 3️⃣ | [**Phase 3, test mode**](05-phase-3-test-mode.md) | Paste the script with enforcement off, confirm it runs |
| 4️⃣ | [**Phase 4, monitor and sign off**](06-phase-4-monitor.md) | Three to five days of real numbers, customer approval |
| 5️⃣ | [**Phase 5, enforce**](07-phase-5-enforce.md) | Switch on, then the nine test acceptance plan |
| 6️⃣ | [**Phase 6, close-out**](08-phase-6-closeout.md) | Re-lock scripting, record the change, handover |
| ↩️ | [**Rollback**](09-rollback.md) | Four scenarios, all zero downtime |
| ⚠️ | [**Known limitations**](10-limitations.md) | Seven items the customer must be briefed on |
| 🔧 | [**Troubleshooting**](11-troubleshooting.md) | Symptom to cause to fix |
| ✉️ | [**End user notice template**](12-user-notice-template.md) | Optional announcement email |

The script itself lives in [`../src/`](../src/) with its own reference notes.

---

## ⏱️ Time budget

| Phase | Hands on time | Elapsed |
|---|---|---|
| 1, server preparation | 20 to 40 min | includes a service restart |
| 2, mono queue | 15 to 30 min | depends on fleet size |
| 3, test mode | 10 min | |
| 4, monitor | 15 min of reading | 3 to 5 working days |
| 5, enforce | 30 to 60 min | the nine tests |
| 6, close-out | 20 min | |

The long pole is Phase 4, and it is deliberate. It is where the customer sees how much of their daily volume the rule touches, before it touches any of it.
