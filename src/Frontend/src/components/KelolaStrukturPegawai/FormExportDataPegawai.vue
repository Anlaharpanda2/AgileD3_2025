<script setup lang="ts">
import { ref } from 'vue'
import { saveAs } from 'file-saver'
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
  data: Array<Record<string, unknown>>
}>()

defineEmits(['close'])



// Kolom-kolom yang akan diekspor
const exportColumns = [
  { key: "nama", label: "Nama" },
  { key: "idPegawai", label: "ID Pegawai" },
  { key: "jabatan", label: "Jabatan" },
  { key: "email", label: "Email" },
  { key: "noHp", label: "No. HP" },
  { key: "alamat", label: "Alamat" },
  { key: "status", label: "Status" },
]

// State untuk input form
const headerDokumen = ref('')
const judulDokumen = ref('')
const showLogo1 = ref(true)
const showLogo2 = ref(true)

// Fungsi untuk mendapatkan tanggal dan waktu saat ini
function getCurrentDateTime(): string {
  const now = new Date()
  return now.toLocaleString('id-ID', {
    day: '2-digit', month: 'long', year: 'numeric',
    hour: '2-digit', minute: '2-digit', second: '2-digit'
  })
}

// Fungsi untuk mendapatkan URL saat ini
function getCurrentUrl(): string {
  return window.location.href
}

// Fungsi untuk mengekspor data ke format Word
async function ExportWord(headerText: string, titleText: string, showLogo1: boolean, showLogo2: boolean) {
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
                  new Paragraph({ children: [new TextRun({ text: headerText, bold: true, size: 24 })], alignment: AlignmentType.CENTER }),
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

  const documentChildren: (Paragraph | Table)[] = [new Paragraph({ text: "", spacing: { after: 200 } })];
  if (titleText) {
    documentChildren.push(new Paragraph({
      children: [new TextRun({ text: titleText, bold: true, size: 24 })],
      alignment: AlignmentType.CENTER,
      spacing: { after: 200 }
    }));
  }
  documentChildren.push(new Table({ rows }));

  const doc = new Document({
    sections: [{ headers: { default: header }, footers: { default: footer }, properties: { page: { size: { orientation: 'landscape' } } }, children: documentChildren }],
  })

  const buffer = await Packer.toBlob(doc)
  saveAs(buffer, 'exported_data_pegawai.docx')
}

// Fungsi untuk mengekspor data ke format PDF
async function ExportPdf(headerText: string, titleText: string, showLogo1: boolean, showLogo2: boolean) {
  const { default: jsPDF } = await import('jspdf');
  const { default: autoTable } = await import('jspdf-autotable');
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
  const headerFontSize = 12
  const titleFontSize = 12

  let currentY = 20

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

  if (logo1Data) doc.addImage(logo1Data.dataUrl, 'PNG', logo1X, currentY, logo1Size.width, logo1Size.height)
  if (logo2Data) doc.addImage(logo2Data.dataUrl, 'PNG', logo2X, currentY, logo2Size.width, logo2Size.height)

  doc.setFontSize(headerFontSize)
  doc.setFont('helvetica', 'bold')
  const centerX = pageWidth / 2
  const headerLines = doc.splitTextToSize(headerText, pageWidth / 3).filter((line: string | null | undefined) => line !== undefined && line !== null);
  
  headerLines.forEach((line: string) => {
    doc.text(line, centerX, currentY, { align: 'center' })
    currentY += headerFontSize * 1.3
  })

  const defaultText = "Jalan Rasuna Said No. 74 Telp. (0751) 7053781 Fax. (0751) 7053781 Padang 25114"
  doc.setFontSize(fontSize8)
  doc.setFont('helvetica', 'normal')
  doc.text(defaultText, centerX, currentY, { align: 'center' })

  const minY = 20 + Math.max(logo1Size.height, logo2Size.height)
  if (currentY < minY) currentY = minY
  currentY += fontSize8 * 1.5

  doc.setLineWidth(2)
  doc.line(margin, currentY, pageWidth - margin, currentY)
  currentY += 15

  if (titleText) {
    doc.setFontSize(titleFontSize)
    doc.setFont('helvetica', 'bold')
    const titleLines = doc.splitTextToSize(String(titleText), pageWidth - (margin * 2)).filter((line: string | null | undefined) => line !== undefined && line !== null);
    titleLines.forEach((line: string) => {
      doc.text(line, centerX, currentY, { align: 'center' })
      currentY += titleFontSize * 1.5
    })
    currentY += 15
  }

  const head = [exportColumns.map(col => col.label)]
  const body = props.data.map(row => exportColumns.map(col => row[col.key] ?? ''))

  const options = {
    head,
    body,
    startY: currentY,
    margin: { left: margin, right: margin },
    headStyles: { fontSize: fontSize8 },
    bodyStyles: { fontSize: fontSize8 },
    styles: { fontSize: fontSize8 },
    didDrawPage: () => {
      const footerY = pageHeight - 20
      doc.setFontSize(fontSize8)
      doc.setFont('helvetica', 'normal')
      doc.text(getCurrentUrl(), margin, footerY, { align: 'left' })
      doc.text(`Dicetak pada: ${getCurrentDateTime()}`, pageWidth - margin, footerY, { align: 'right' })
    },
  }

  autoTable(doc, options)
  doc.save("exported_data_pegawai.pdf")
}

// Fungsi untuk mengekspor data ke format Excel menggunakan XLSX
async function ExportExcel() {
  const XLSX = await import('xlsx');
  // Siapkan data dalam format array of arrays, termasuk header
  const dataToExport = [
    exportColumns.map(col => col.label), // Baris header
    ...props.data.map(row => exportColumns.map(col => row[col.key] ?? '')) // Baris data
  ];

  // Buat worksheet dari array of arrays
  const ws = XLSX.utils.aoa_to_sheet(dataToExport);

  // Atur lebar kolom
  ws['!cols'] = exportColumns.map(col => ({
    wch: Math.max(col.label.length, 15)
  }));

  // Buat workbook baru dan tambahkan worksheet
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Data");

  // Tulis workbook ke buffer
  const excelBuffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });

  // Simpan file menggunakan file-saver
  saveAs(new Blob([excelBuffer], { type: "application/octet-stream" }), "exported_data_pegawai.xlsx");

  ElNotification({ message: 'Data berhasil diekspor ke Excel!', type: 'success', duration: 3000 });
}

// Handler utama untuk proses ekspor
function ExportHandler(format: 'word' | 'pdf' | 'excel') {
  if (format === 'excel') {
    ExportExcel()
  } else {
    if (!headerDokumen.value.trim()) {
      ElNotification({ message: 'Header Dokumen tidak boleh kosong!', type: 'warning', duration: 3000 })
      return
    }
    if (format === 'word') {
      ExportWord(headerDokumen.value, judulDokumen.value, showLogo1.value, showLogo2.value)
    } else if (format === 'pdf') {
      ExportPdf(headerDokumen.value, judulDokumen.value, showLogo1.value, showLogo2.value)
    }
  }
}
</script>

<template>
  <div
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 animate-fade-in p-4"
    @click.self="$emit('close')"
  >
    <div class="relative bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20 p-8 w-full max-w-md mx-auto animate-scale-in max-h-[90vh] overflow-y-auto md:max-h-auto">
      <button
        class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-all duration-200 hover:scale-110 group"
        @click="$emit('close')"
      >
        <svg
          class="w-4 h-4 text-gray-500 group-hover:text-gray-700"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>

      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-pink-300 to-pink-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
          <svg
            class="w-8 h-8 text-white"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
          Export Data Pegawai
        </h2>
        <p class="text-gray-600 text-sm">
          Pilih format export dan konfigurasi dokumen
        </p>
      </div>

      <div class="space-y-6">
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <svg
              class="w-4 h-4 inline mr-2 text-pink-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
            Header Dokumen
          </label>
          <div class="relative">
            <input
              v-model="headerDokumen"
              type="text"
              placeholder="Masukkan teks header untuk PDF & Word"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition-all duration-200 placeholder-gray-400"
            >
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
              <svg
                class="w-4 h-4 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                />
              </svg>
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <svg
              class="w-4 h-4 inline mr-2 text-pink-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
            Judul Dokumen (Opsional)
          </label>
          <div class="relative">
            <input
              v-model="judulDokumen"
              type="text"
              placeholder="Masukkan judul dokumen (di bawah header)"
              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-transparent transition-all duration-200 placeholder-gray-400"
            >
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
              <svg
                class="w-4 h-4 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                />
              </svg>
            </div>
          </div>
        </div>

        <div class="space-y-3">
          <label class="text-sm font-semibold text-gray-700 block">
            <svg
              class="w-4 h-4 inline mr-2 text-pink-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>
            Opsi Logo
          </label>
          
          <div class="space-y-3">
            <label class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer group">
              <input
                v-model="showLogo1"
                type="checkbox"
                class="w-4 h-4 text-pink-400 bg-gray-100 border-gray-300 rounded focus:ring-pink-300 focus:ring-2"
              >
              <div class="ml-3 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-sky-300 to-sky-400 rounded-lg flex items-center justify-center mr-3">
                  <svg
                    class="w-4 h-4 text-white"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1V4zm2 2V5h1v1h-1z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Logo Tuah Sakato</span>
              </div>
            </label>

            <label class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer group">
              <input
                v-model="showLogo2"
                type="checkbox"
                class="w-4 h-4 text-pink-400 bg-gray-100 border-gray-300 rounded focus:ring-pink-300 focus:ring-2"
              >
              <div class="ml-3 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-emerald-300 to-emerald-400 rounded-lg flex items-center justify-center mr-3">
                  <svg
                    class="w-4 h-4 text-white"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Logo Padang Kota Tercinta</span>
              </div>
            </label>
          </div>
        </div>

        <div class="space-y-3 pt-2">
          <p class="text-sm font-semibold text-gray-700 mb-3">
            <svg
              class="w-4 h-4 inline mr-2 text-pink-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
              />
            </svg>
            Format Export
          </p>
          
          <button
            class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-400 to-emerald-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-emerald-500 hover:to-emerald-600 transform hover:scale-105 transition-all duration-200 group"
            @click="ExportHandler('excel')"
          >
            <svg
              class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"
                clip-rule="evenodd"
              />
            </svg>
            Export Excel
            <span class="ml-2 text-xs bg-white/30 px-2 py-1 rounded-full">XLSX</span>
          </button>

          <button
            class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-rose-400 to-rose-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-rose-500 hover:to-rose-600 transform hover:scale-105 transition-all duration-200 group"
            @click="ExportHandler('pdf')"
          >
            <svg
              class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                clip-rule="evenodd"
              />
            </svg>
            Export PDF
            <span class="ml-2 text-xs bg-white/30 px-2 py-1 rounded-full">PDF</span>
          </button>

          <button
            class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-sky-400 to-sky-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-sky-500 hover:to-sky-600 transform hover:scale-105 transition-all duration-200 group"
            @click="ExportHandler('word')"
          >
            <svg
              class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                clip-rule="evenodd"
              />
            </svg>
            Export Word
            <span class="ml-2 text-xs bg-white/30 px-2 py-1 rounded-full">DOCX</span>
          </button>
        </div>

        <div class="mt-6 p-4 bg-gradient-to-r from-pink-50 to-pink-100 rounded-xl border border-pink-200">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-pink-400 rounded-lg flex items-center justify-center mr-3">
              <svg
                class="w-4 h-4 text-white"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div>
              <p class="text-sm font-semibold text-pink-700">
                {{ props.data.length }} Data Siap Export
              </p>
              <p class="text-xs text-pink-500">
                Data pegawai akan diekspor sesuai format yang dipilih
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes scale-in {
  from {
    opacity: 0;
    transform: scale(0.95) translateY(-10px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out forwards;
}

.animate-scale-in {
  animation: scale-in 0.3s ease-out forwards;
}

.max-h-\[90vh\] {
  max-height: 90vh;
}

.overflow-y-auto {
  overflow-y: auto;
}

@media (max-width: 768px) {
  .max-w-md {
    max-width: 95%;
  }
  .p-8 {
    padding: 1.5rem;
  }
}

@media (min-width: 769px) {
  .md\:max-h-auto {
    max-height: auto !important;
  }
  .md\:max-h-auto::-webkit-scrollbar {
    width: 0px;
    background: transparent;
  }
  .md\:max-h-auto {
    scrollbar-width: none;
  }
}


::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #dbeafe; /* pink-200 */
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #60a5fa; /* pink-400 */
}
</style>
