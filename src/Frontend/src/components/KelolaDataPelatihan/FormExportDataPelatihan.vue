<script setup lang="ts">
import { ref } from 'vue'
import * as XLSX from 'xlsx'
import { saveAs } from 'file-saver'
import jsPDF from 'jspdf'
import autoTable, { UserOptions } from 'jspdf-autotable'
import {
  Document,
  Packer,
  Paragraph,
  Table,
  TableRow,
  TableCell,
  Header,
  Footer,
  AlignmentType,
  TextRun,
  BorderStyle,
  WidthType,
  ImageRun,
} from 'docx'
import { ElNotification } from 'element-plus'

const props = defineProps<{
  data: Array<Record<string, any>>
}>()

const exportColumns = [
  { key: "nama", label: "Nama" },
  { key: "nik", label: "NIK" },
  { key: "jenis_bimtek", label: "Jenis Bimtek" },
  { key: "tanggal_kegiatan", label: "Tanggal Kegiatan" },
  { key: "tempat_kegiatan", label: "Tempat Kegiatan" },
  { key: "angkatan", label: "Angkatan" },
  { key: "alamat", label: "Alamat" },
  { key: "tempat_tanggal_lahir", label: "tempat tanggal lahir" },
  { key: "pendidikan", label: "Pendidikan" },
  { key: "status", label: "Status" },
  { key: "jenis_usaha", label: "Jenis Usaha" },
  { key: "penghasilan_perbulan", label: "Penghasilan" },
  { key: "nomor_telefon", label: "No. Telp" },
]

const judul = ref('')
const showLogo1 = ref(true)
const showLogo2 = ref(true)

function getCurrentDateTime(): string {
  const now = new Date()
  return now.toLocaleString('id-ID', {
    day: '2-digit', month: 'long', year: 'numeric',
    hour: '2-digit', minute: '2-digit', second: '2-digit'
  })
}

function getCurrentUrl(): string {
  return window.location.href
}

async function ExportWord(title: string, showLogo1: boolean, showLogo2: boolean) {
  const logoLeftBuffer = showLogo1
    ? await fetch("/export/logo1.png")
        .then(res => res.arrayBuffer())
        .then(buffer => new Uint8Array(buffer))
    : null

  const logoRightBuffer = showLogo2
    ? await fetch("/export/logo2.png")
        .then(res => res.arrayBuffer())
        .then(buffer => new Uint8Array(buffer))
    : null

  const rows = [
    new TableRow({
      children: exportColumns.map(col =>
        new TableCell({
          children: [
            new Paragraph({
              children: [new TextRun({ text: col.label, size: 16 })],
              alignment: AlignmentType.CENTER,
            }),
          ],
        })
      ),
    }),
    ...props.data.map(row =>
      new TableRow({
        children: exportColumns.map(col =>
          new TableCell({
            children: [
              new Paragraph({
                children: [new TextRun({ text: String(row[col.key] ?? ''), size: 16 })],
              }),
            ],
          })
        ),
      })
    ),
  ]

  const header = new Header({
    children: [
      new Table({
        width: { size: 100, type: WidthType.PERCENTAGE },
        borders: { top: { style: BorderStyle.NONE, size: 0, color: "FFFFFF" }, bottom: { style: BorderStyle.NONE, size: 0, color: "FFFFFF" }, left: { style: BorderStyle.NONE, size: 0, color: "FFFFFF" }, right: { style: BorderStyle.NONE, size: 0, color: "FFFFFF" }, insideHorizontal: { style: BorderStyle.NONE, size: 0, color: "FFFFFF" }, insideVertical: { style: BorderStyle.NONE, size: 0, color: "FFFFFF" } },
        rows: [
          new TableRow({
            children: [
              new TableCell({
                children: showLogo1 && logoLeftBuffer ? [new Paragraph({ children: [
                  new ImageRun({
                  data: logoLeftBuffer,
                  transformation: { width: 60, height: 60 },
                  type: "png",
                })
                ], alignment: AlignmentType.CENTER })] : [new Paragraph({ text: "" })],
                verticalAlign: "center",
                width: { size: 20, type: WidthType.PERCENTAGE },
              }),
              new TableCell({
                children: [
                  new Paragraph({ children: [new TextRun({ text: title, bold: true, size: 24 })], alignment: AlignmentType.CENTER }),
                  new Paragraph({ children: [new TextRun({ text: "Jalan Rasuna Said No. 74 Telp. (0751) 7053781 Fax. (0751) 7053781 Padang 25114", size: 16 })], alignment: AlignmentType.CENTER }),
                ],
                verticalAlign: "center",
                width: { size: 60, type: WidthType.PERCENTAGE },
              }),
              new TableCell({
                children: showLogo2 && logoRightBuffer ? [new Paragraph({ children: [new ImageRun({
                  data: logoRightBuffer,
                  transformation: { width: 60, height: 60 },
                  type: "png",
                })], alignment: AlignmentType.CENTER })] : [new Paragraph({ text: "" })],
                verticalAlign: "center",
                width: { size: 20, type: WidthType.PERCENTAGE },
              }),
            ],
          }),
          new TableRow({
            children: [new TableCell({ children: [], columnSpan: 3, borders: { bottom: { style: BorderStyle.SINGLE, size: 8, color: "000000" } } })],
          }),
        ],
      }),
    ],
  })

  const footer = new Footer({
    children: [
      new Paragraph({ children: [new TextRun({ text: getCurrentUrl(), size: 16, color: "0000FF" })], alignment: AlignmentType.LEFT }),
      new Paragraph({ children: [new TextRun({ text: `Dicetak pada: ${getCurrentDateTime()}`, size: 16 })], alignment: AlignmentType.RIGHT }),
    ],
  })

  const doc = new Document({
    sections: [{ headers: { default: header }, footers: { default: footer }, properties: { page: { size: { orientation: 'landscape' } } }, children: [new Paragraph({ text: "", spacing: { after: 200 } }), new Table({ rows })] }],
  })

  const buffer = await Packer.toBlob(doc)
  saveAs(buffer, 'exported_data.docx')
}

async function ExportPdf(title: string, showLogo1: boolean, showLogo2: boolean) {
  async function loadImageAsDataUrlWithSize(url: string): Promise<{ dataUrl: string, width: number, height: number }> {
    return new Promise((resolve, reject) => {
      const img = new Image()
      img.crossOrigin = 'Anonymous'
      img.onload = () => {
        const canvas = document.createElement('canvas')
        canvas.width = img.width
        canvas.height = img.height
        const ctx = canvas.getContext('2d')
        if (!ctx) return reject('Failed to get canvas context')
        ctx.drawImage(img, 0, 0)
        const dataUrl = canvas.toDataURL('image/png')
        resolve({ dataUrl, width: img.width, height: img.height })
      }
      img.onerror = (e) => reject(e)
      img.src = url
    })
  }

  const doc = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' })
  const pageWidth = doc.internal.pageSize.getWidth()
  const pageHeight = doc.internal.pageSize.getHeight()
  const margin = 40
  const fontSize8 = 8
  const titleFontSize = 12
  const startY = 20

  const [logo1Data, logo2Data] = await Promise.all([
    showLogo1 ? loadImageAsDataUrlWithSize('/export/logo1.png') : null,
    showLogo2 ? loadImageAsDataUrlWithSize('/export/logo2.png') : null,
  ])

  const fixedImgWidth = 60
  const logo1Size = logo1Data ? { width: fixedImgWidth, height: fixedImgWidth } : { width: 0, height: 0 }
  const logo2Size = logo2Data ? { width: fixedImgWidth, height: fixedImgWidth } : { width: 0, height: 0 }


  const colWidth = pageWidth / 3
  const logo1X = colWidth / 2 - logo1Size.width / 2
  const logo2X = colWidth * 2.5 - logo2Size.width / 2

  if (logo1Data) doc.addImage(logo1Data.dataUrl, 'PNG', logo1X, startY, logo1Size.width, logo1Size.height)
  if (logo2Data) doc.addImage(logo2Data.dataUrl, 'PNG', logo2X, startY, logo2Size.width, logo2Size.height)

  doc.setFontSize(titleFontSize)
  doc.setFont(undefined, 'bold')
  const centerX = pageWidth / 2
  const titleLines = doc.splitTextToSize(title, pageWidth / 3)
  let currentY = startY + 5
  titleLines.forEach(line => {
    doc.text(line, centerX, currentY, { align: 'center' })
    currentY += titleFontSize * 1.3
  })
  const defaultText = "Jalan Rasuna Said No. 74 Telp. (0751) 7053781 Fax. (0751) 7053781 Padang 25114"
  doc.setFontSize(fontSize8)
  doc.setFont(undefined, 'normal')
  doc.text(defaultText, centerX, currentY, { align: 'center' })

  const minY = startY + Math.max(logo1Size.height, logo2Size.height)
  if (currentY < minY) currentY = minY
  currentY += fontSize8 * 1.5
  doc.setLineWidth(2)
  doc.line(margin, currentY, pageWidth - margin, currentY)

  const head = [exportColumns.map(col => col.label)]
  const body = props.data.map(row => exportColumns.map(col => row[col.key] ?? ''))
  const options: UserOptions = {
    head,
    body,
    startY: currentY + 15,
    margin: { left: margin, right: margin },
    headStyles: { fontSize: fontSize8 },
    bodyStyles: { fontSize: fontSize8 },
    styles: { fontSize: fontSize8 },
    didDrawPage: () => {
      const footerY = pageHeight - 20
      doc.setFontSize(fontSize8)
      doc.setFont(undefined, 'normal')
      doc.text(getCurrentUrl(), margin, footerY, { align: 'left' })
      doc.text(`Dicetak pada: ${getCurrentDateTime()}`, pageWidth - margin, footerY, { align: 'right' })
    },
  }

  autoTable(doc, options)
  doc.save("exported_data.pdf")
}

function ExportExcel() {
  const worksheetData = [
    exportColumns.map(col => col.label),
    ...props.data.map(row => exportColumns.map(col => row[col.key] ?? ''))
  ]
  const worksheet = XLSX.utils.aoa_to_sheet(worksheetData)
  const workbook = XLSX.utils.book_new()
  XLSX.utils.book_append_sheet(workbook, worksheet, "Data")
  const wbout = XLSX.write(workbook, { bookType: "xlsx", type: "array" })
  saveAs(new Blob([wbout], { type: "application/octet-stream" }), "exported_data.xlsx")
}

function ExportHandler(format: 'word' | 'pdf' | 'excel') {
  if (format === 'excel') return ExportExcel()
  if (!judul.value.trim()) return ElNotification({ message: 'Judul tidak boleh kosong!', type: 'warning', duration: 3000 })
  if (format === 'word') ExportWord(judul.value, showLogo1.value, showLogo2.value)
  else if (format === 'pdf') ExportPdf(judul.value, showLogo1.value, showLogo2.value)
}
</script>

<template>
  <div class="overlay" @click.self="$emit('close')">
    <div class="popup">
      <button class="close-btn" @click="$emit('close')">&times;</button>
      <h2 class="title">Export Data</h2>

      <div class="form-group">
        <label for="judul">Judul Dokumen</label>
        <input
          v-model="judul"
          id="judul"
          type="text"
          placeholder="Masukkan judul untuk PDF & Word"
          class="input"
        />
      </div>

      <div class="form-group checkbox-group">
        <label><input type="checkbox" v-model="showLogo1" /> Logo Tuah Sakato</label>
        <label><input type="checkbox" v-model="showLogo2" /> Logo Padang Kota Tercinta</label>
      </div>

      <div class="buttons">
        <button @click="ExportHandler('excel')">Export Excel</button>
        <button @click="ExportHandler('pdf')">Export PDF</button>
        <button @click="ExportHandler('word')">Export Word</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.3s ease forwards;
  z-index: 1000;
}

.popup {
  position: relative;
  background: white;
  padding: 32px;
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  width: 360px;
  max-width: 90vw;
  animation: scaleIn 0.3s ease forwards;
}

.title {
  margin-bottom: 24px;
  font-size: 1.5rem;
  font-weight: 600;
  color: #333;
  text-align: center;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.form-group label {
  margin-bottom: 8px;
  font-weight: 500;
  font-size: 0.95rem;
  color: #555;
}

.input {
  padding: 10px 12px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
  transition: border-color 0.2s ease;
}

.input:focus {
  border-color: #69C5C2;
}

.checkbox-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 20px;
  font-size: 0.9rem;
  color: #444;
}

.buttons {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

button {
  padding: 12px;
  font-size: 1rem;
  font-weight: 500;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  background-color: #69C5C2;
  color: white;
  transition: background-color 0.2s ease;
}

button:hover {
  background-color: #4fb1ae;
}

.close-btn {
  position: absolute;
  top: 14px;
  right: 16px;
  background: transparent;
  font-size: 1.5rem;
  color: #888;
  border: none;
  cursor: pointer;
  transition: color 0.2s ease;
}

.close-btn:hover {
  color: #444;
}

/* Animations */
@keyframes fadeIn {
  from {
    background-color: rgba(0, 0, 0, 0);
  }
  to {
    background-color: rgba(0, 0, 0, 0.6);
  }
}

@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.85);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
