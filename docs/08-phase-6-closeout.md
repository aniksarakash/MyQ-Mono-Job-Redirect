# 6️⃣ Phase 6, Close-out

Three steps. Step 6.1 is the one that gets forgotten, and it is the one an auditor looks for.

---

## Step 6.1 🔒 Re-lock Job Scripting

**Easy Config → Security → disable Unlock PHP Scripting.**

The script keeps running. Only editing is blocked.

Do this at every bank site. A VAPT reviewer will flag an unlocked scripting engine, and the control exists because of CVE-2024-22076.

> ℹ️ To edit the script later, re-enable the toggle, restart services, make the change, then disable it again. Build that into any future change request.

---

## Step 6.2 📝 Record the change

| Item | Detail to capture |
|---|---|
| Scripting unlock window | Who unlocked it, when, and when it was re-locked |
| New queue | `secure_mono` added, with its full printer list |
| Untouched queue | Written confirmation that `secure` was not modified |
| Limitation acceptance | The content based limitation and the customer's written acceptance |
| Phase 4 numbers | The redirect percentage the customer approved against |
| Test results | The nine test table from [Phase 5](07-phase-5-enforce.md), signed |

---

## Step 6.3 🤝 Handover

Give the customer's IT team:

| Document | Why they need it |
|---|---|
| This runbook | So they can see what was changed and why |
| [Rollback procedure](09-rollback.md) | So a first line engineer can disable the rule at 9am without calling you |
| [Known limitations](10-limitations.md) | So their service desk can answer the questions before escalating |
| [Troubleshooting table](11-troubleshooting.md) | Symptom to cause to fix, no MyQ expertise required |

The rollback page is the important one. A customer who knows they can turn it off in ten seconds is a customer who lets you leave it on.

---

## ✅ Phase 6 exit criteria

| Check | State |
|---|:---:|
| Unlock PHP Scripting disabled in Easy Config | ☐ |
| Script confirmed still running after re-lock | ☐ |
| Change record completed | ☐ |
| Customer written acceptance filed | ☐ |
| Runbook and rollback handed to customer IT | ☐ |

---

*Next: [Rollback](09-rollback.md)*
