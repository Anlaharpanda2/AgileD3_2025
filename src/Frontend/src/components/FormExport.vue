<script setup lang="ts">
import { ref } from 'vue'
import * as XLSX from 'xlsx'
import { saveAs } from 'file-saver'
import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'
import {
  Document,
  Packer,
  Paragraph,
  Table,
  TableRow,
  TableCell,
  HeadingLevel,
} from 'docx'


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
  { key: "pendidikan", label: "Pendidikan" },
  { key: "status", label: "Status" },
  { key: "jenis_usaha", label: "Jenis Usaha" },
  { key: "penghasilan_perbulan", label: "Penghasilan" },
  { key: "nomor_telefon", label: "No. Telp" },
]

function exportExcel() {
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

function exportPDF() {
  const doc = new jsPDF({
    orientation: 'landscape',
    unit: 'pt',
    format: 'a4',
  })
  const head = [exportColumns.map(col => col.label)]
  const body = props.data.map(row => exportColumns.map(col => row[col.key] ?? ''))
  autoTable(doc, {
    head,
    body,
  })
  doc.save("exported_data.pdf")
}

const judul = ref('')

async function exportWord(title) {
  const rows = [
    new TableRow({
      children: exportColumns.map(col =>
        new TableCell({
          children: [new Paragraph(col.label)],
        }),
      ),
    }),
    ...props.data.map(row =>
      new TableRow({
        children: exportColumns.map(col =>
          new TableCell({
            children: [new Paragraph(String(row[col.key] ?? ''))],
          }),
        ),
      }),
    ),
  ]

  const doc = new Document({
    sections: [
      {
        properties: {
          page: {
            size: {
              orientation: 'landscape',
            },
          },
        },
        children: [
          new Paragraph({
            text: title,
            heading: HeadingLevel.TITLE,
            spacing: { after: 300 },
            alignment: 'center',
          }),
          new Table({
            rows,
          }),
        ],
      },
    ],
  })

  const buffer = await Packer.toBlob(doc)
  saveAs(buffer, 'exported_data.docx')
}

function exportWordHandler() {
  if (!judul.value.trim()) {
    alert('Judul tidak boleh kosong!')
    return
  }
  exportWord(judul.value)
}
</script>

<template>
  <div class="overlay" @click.self="$emit('close')">
    <div class="popup">
      <h2>Export Data</h2>
      <input
        v-model="judul"
        type="text"
        placeholder="Masukkan judul untuk dokumen"
        class="input-judul"
      />
      <div class="buttons">
        <button @click="exportExcel">Export Excel</button>
        <button @click="exportPDF">Export PDF</button>
        <button @click="exportWordHandler">Export Word</button>
      </div>
      <button class="close-btn" @click="$emit('close')">&times;</button>
    </div>
  </div>
</template>

<style scoped>
.overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.3s ease forwards;
  z-index: 1000;
}

.popup {
  position: relative;
  background: white;
  padding: 24px 32px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  width: 320px;
  max-width: 90vw;
  text-align: center;
  animation: scaleIn 0.3s ease forwards;
}

.buttons {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-top: 20px;
}

button {
  padding: 10px 16px;
  font-size: 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  background-color: #69C5C2;
  color: white;
  transition: background-color 0.2s ease;
}

button:hover {
  background-color: #549b98;
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 16px;
  background: transparent;
  font-size: 1.5rem;
  color: #888;
  border: none;
  cursor: pointer;
  transition: color 0.2s ease;
}
.input-judul {
  padding: 8px;
  width: 100%;
  max-width: 400px;
  margin-bottom: 10px;
  font-size: 1rem;
}
.close-btn:hover {
  color: #555;
}

/* Animations */
@keyframes fadeIn {
  from { background-color: rgba(0,0,0,0); }
  to { background-color: rgba(0,0,0,0.6); }
}
@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.8);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
