<template>
  <div class="crud-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="header-content">
        <h1 class="main-title">
          <el-icon class="title-icon"><UserFilled /></el-icon>
          Manajemen Karyawan
        </h1>
        <p class="subtitle">Sistem CRUD dengan Vue 3 & Element Plus</p>
      </div>
      <div class="header-stats">
        <div class="stat-card">
          <div class="stat-number">{{ employees.length }}</div>
          <div class="stat-label">Total Karyawan</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">{{ activeEmployees }}</div>
          <div class="stat-label">Aktif</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">{{ inactiveEmployees }}</div>
          <div class="stat-label">Tidak Aktif</div>
        </div>
      </div>
    </div>

    <!-- Controls Section -->
    <div class="controls-section">
      <div class="search-section">
        <el-input
          v-model="searchQuery"
          placeholder="Cari karyawan..."
          size="large"
          clearable
          class="search-input"
        >
          <template #prefix>
            <el-icon><Search /></el-icon>
          </template>
        </el-input>
      </div>
      
      <div class="action-buttons">
        <el-button
          type="primary"
          size="large"
          @click="showAddDialog"
          class="add-btn"
        >
          <el-icon><Plus /></el-icon>
          Tambah Karyawan
        </el-button>
        
        <el-dropdown @command="handleBulkAction" class="bulk-dropdown">
          <el-button size="large">
            Aksi Massal
            <el-icon class="el-icon--right"><ArrowDown /></el-icon>
          </el-button>
          <template #dropdown>
            <el-dropdown-menu>
              <el-dropdown-item command="export">
                <el-icon><Download /></el-icon>
                Export Data
              </el-dropdown-item>
              <el-dropdown-item command="delete" divided>
                <el-icon><Delete /></el-icon>
                Hapus Terpilih
              </el-dropdown-item>
            </el-dropdown-menu>
          </template>
        </el-dropdown>
      </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
      <el-row :gutter="20">
        <el-col :span="6">
          <el-select
            v-model="filters.department"
            placeholder="Filter Departemen"
            clearable
            size="default"
            style="width: 100%"
          >
            <el-option
              v-for="dept in departments"
              :key="dept"
              :label="dept"
              :value="dept"
            />
          </el-select>
        </el-col>
        <el-col :span="6">
          <el-select
            v-model="filters.status"
            placeholder="Filter Status"
            clearable
            size="default"
            style="width: 100%"
          >
            <el-option label="Aktif" value="active" />
            <el-option label="Tidak Aktif" value="inactive" />
          </el-select>
        </el-col>
        <el-col :span="6">
          <el-date-picker
            v-model="filters.dateRange"
            type="daterange"
            range-separator="s/d"
            start-placeholder="Tanggal Mulai"
            end-placeholder="Tanggal Akhir"
            size="default"
            style="width: 100%"
          />
        </el-col>
        <el-col :span="6">
          <el-button @click="clearFilters" size="default" style="width: 100%">
            <el-icon><RefreshLeft /></el-icon>
            Reset Filter
          </el-button>
        </el-col>
      </el-row>
    </div>

    <!-- Table Section -->
    <div class="table-section">
      <el-table
        :data="filteredEmployees"
        v-loading="loading"
        stripe
        highlight-current-row
        @selection-change="handleSelectionChange"
        class="main-table"
        :row-class-name="tableRowClassName"
      >
        <el-table-column type="selection" width="55" />
        <el-table-column type="index" label="No" width="60" />
        
        <el-table-column prop="name" label="Nama" min-width="150" sortable>
          <template #default="{ row }">
            <div class="employee-info">
              <el-avatar :size="32" :src="row.avatar" class="employee-avatar">
                {{ row.name.charAt(0) }}
              </el-avatar>
              <div class="employee-details">
                <div class="employee-name">{{ row.name }}</div>
                <div class="employee-position">{{ row.position }}</div>
              </div>
            </div>
          </template>
        </el-table-column>
        
        <el-table-column prop="email" label="Email" min-width="200" sortable />
        
        <el-table-column prop="department" label="Departemen" width="130" sortable>
          <template #default="{ row }">
            <el-tag :type="getDepartmentTagType(row.department)" size="small">
              {{ row.department }}
            </el-tag>
          </template>
        </el-table-column>
        
        <el-table-column prop="salary" label="Gaji" width="120" sortable>
          <template #default="{ row }">
            <span class="salary-text">
              {{ formatCurrency(row.salary) }}
            </span>
          </template>
        </el-table-column>
        
        <el-table-column prop="joinDate" label="Tanggal Bergabung" width="140" sortable>
          <template #default="{ row }">
            {{ formatDate(row.joinDate) }}
          </template>
        </el-table-column>
        
        <el-table-column prop="status" label="Status" width="100">
          <template #default="{ row }">
            <el-switch
              v-model="row.status"
              active-value="active"
              inactive-value="inactive"
              @change="updateStatus(row)"
              :loading="row.statusLoading"
            />
          </template>
        </el-table-column>
        
        <el-table-column label="Aksi" width="140" fixed="right">
          <template #default="{ row }">
            <div class="action-buttons-cell">
              <el-tooltip content="Edit" placement="top">
                <el-button
                  type="primary"
                  size="small"
                  circle
                  @click="editEmployee(row)"
                  :icon="Edit"
                />
              </el-tooltip>
              <el-tooltip content="Hapus" placement="top">
                <el-button
                  type="danger"
                  size="small"
                  circle
                  @click="deleteEmployee(row)"
                  :icon="Delete"
                />
              </el-tooltip>
            </div>
          </template>
        </el-table-column>
      </el-table>

      <!-- Pagination -->
      <div class="pagination-section">
        <el-pagination
          v-model:current-page="currentPage"
          v-model:page-size="pageSize"
          :page-sizes="[10, 20, 50, 100]"
          :total="filteredEmployees.length"
          layout="total, sizes, prev, pager, next, jumper"
          background
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </div>
    </div>

    <!-- Add/Edit Dialog -->
    <el-dialog
      v-model="dialogVisible"
      :title="dialogTitle"
      width="600px"
      :before-close="handleClose"
      class="employee-dialog"
    >
      <el-form
        ref="employeeForm"
        :model="currentEmployee"
        :rules="formRules"
        label-width="120px"
        label-position="left"
      >
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Nama" prop="name">
              <el-input
                v-model="currentEmployee.name"
                placeholder="Masukkan nama lengkap"
                clearable
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Email" prop="email">
              <el-input
                v-model="currentEmployee.email"
                placeholder="email@example.com"
                clearable
              />
            </el-form-item>
          </el-col>
        </el-row>

        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Posisi" prop="position">
              <el-input
                v-model="currentEmployee.position"
                placeholder="Jabatan/Posisi"
                clearable
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Departemen" prop="department">
              <el-select
                v-model="currentEmployee.department"
                placeholder="Pilih departemen"
                style="width: 100%"
              >
                <el-option
                  v-for="dept in departments"
                  :key="dept"
                  :label="dept"
                  :value="dept"
                />
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>

        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Gaji" prop="salary">
              <el-input-number
                v-model="currentEmployee.salary"
                :min="0"
                :step="100000"
                controls-position="right"
                style="width: 100%"
                placeholder="0"
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Tanggal Masuk" prop="joinDate">
              <el-date-picker
                v-model="currentEmployee.joinDate"
                type="date"
                placeholder="Pilih tanggal"
                style="width: 100%"
              />
            </el-form-item>
          </el-col>
        </el-row>

        <el-form-item label="Status" prop="status">
          <el-radio-group v-model="currentEmployee.status">
            <el-radio value="active">Aktif</el-radio>
            <el-radio value="inactive">Tidak Aktif</el-radio>
          </el-radio-group>
        </el-form-item>
      </el-form>

      <template #footer>
        <div class="dialog-footer">
          <el-button @click="dialogVisible = false" size="large">
            Batal
          </el-button>
          <el-button
            type="primary"
            @click="saveEmployee"
            :loading="saveLoading"
            size="large"
          >
            {{ isEditing ? 'Update' : 'Simpan' }}
          </el-button>
        </div>
      </template>
    </el-dialog>
  </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, nextTick } from 'vue'
import {
  ElMessage,
  ElMessageBox,
  ElNotification
} from 'element-plus'
import {
  UserFilled,
  Search,
  Plus,
  ArrowDown,
  Download,
  Delete,
  RefreshLeft,
  Edit
} from '@element-plus/icons-vue'

// Reactive data
const employees = ref([])
const searchQuery = ref('')
const loading = ref(false)
const dialogVisible = ref(false)
const isEditing = ref(false)
const currentEmployee = ref({})
const selectedEmployees = ref([])
const saveLoading = ref(false)
const currentPage = ref(1)
const pageSize = ref(10)

// Filters
const filters = reactive({
  department: '',
  status: '',
  dateRange: null
})

// Form reference
const employeeForm = ref(null)

// Departments list
const departments = ref([
  'IT', 'HR', 'Finance', 'Marketing', 'Operations', 'Sales'
])

// Form validation rules
const formRules = {
  name: [
    { required: true, message: 'Nama harus diisi', trigger: 'blur' },
    { min: 2, max: 50, message: 'Nama harus 2-50 karakter', trigger: 'blur' }
  ],
  email: [
    { required: true, message: 'Email harus diisi', trigger: 'blur' },
    { type: 'email', message: 'Format email tidak valid', trigger: 'blur' }
  ],
  position: [
    { required: true, message: 'Posisi harus diisi', trigger: 'blur' }
  ],
  department: [
    { required: true, message: 'Departemen harus dipilih', trigger: 'change' }
  ],
  salary: [
    { required: true, message: 'Gaji harus diisi', trigger: 'blur' },
    { type: 'number', min: 1, message: 'Gaji harus lebih dari 0', trigger: 'blur' }
  ],
  joinDate: [
    { required: true, message: 'Tanggal masuk harus diisi', trigger: 'change' }
  ]
}

// Computed properties
const dialogTitle = computed(() => {
  return isEditing.value ? 'Edit Karyawan' : 'Tambah Karyawan Baru'
})

const activeEmployees = computed(() => {
  return employees.value.filter(emp => emp.status === 'active').length
})

const inactiveEmployees = computed(() => {
  return employees.value.filter(emp => emp.status === 'inactive').length
})

const filteredEmployees = computed(() => {
  let filtered = employees.value

  // Search filter
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(emp =>
      emp.name.toLowerCase().includes(query) ||
      emp.email.toLowerCase().includes(query) ||
      emp.position.toLowerCase().includes(query)
    )
  }

  // Department filter
  if (filters.department) {
    filtered = filtered.filter(emp => emp.department === filters.department)
  }

  // Status filter
  if (filters.status) {
    filtered = filtered.filter(emp => emp.status === filters.status)
  }

  // Date range filter
  if (filters.dateRange && filters.dateRange.length === 2) {
    const [startDate, endDate] = filters.dateRange
    filtered = filtered.filter(emp => {
      const joinDate = new Date(emp.joinDate)
      return joinDate >= startDate && joinDate <= endDate
    })
  }

  return filtered
})

// Methods
const initializeData = () => {
  // Sample data
  employees.value = [
    {
      id: 1,
      name: 'Ahmad Wijaya',
      email: 'ahmad.wijaya@company.com',
      position: 'Senior Developer',
      department: 'IT',
      salary: 15000000,
      joinDate: '2022-01-15',
      status: 'active',
      avatar: 'https://i.pravatar.cc/150?img=1'
    },
    {
      id: 2,
      name: 'Siti Nurhaliza',
      email: 'siti.nurhaliza@company.com',
      position: 'HR Manager',
      department: 'HR',
      salary: 12000000,
      joinDate: '2021-03-20',
      status: 'active',
      avatar: 'https://i.pravatar.cc/150?img=2'
    },
    {
      id: 3,
      name: 'Budi Santoso',
      email: 'budi.santoso@company.com',
      position: 'Marketing Specialist',
      department: 'Marketing',
      salary: 8000000,
      joinDate: '2023-05-10',
      status: 'inactive',
      avatar: 'https://i.pravatar.cc/150?img=3'
    },
    {
      id: 4,
      name: 'Maya Sari',
      email: 'maya.sari@company.com',
      position: 'Finance Analyst',
      department: 'Finance',
      salary: 10000000,
      joinDate: '2022-08-01',
      status: 'active',
      avatar: 'https://i.pravatar.cc/150?img=4'
    },
    {
      id: 5,
      name: 'Rizki Pratama',
      email: 'rizki.pratama@company.com',
      position: 'Sales Executive',
      department: 'Sales',
      salary: 7500000,
      joinDate: '2023-02-14',
      status: 'active',
      avatar: 'https://i.pravatar.cc/150?img=5'
    }
  ]
}

const showAddDialog = () => {
  isEditing.value = false
  currentEmployee.value = {
    name: '',
    email: '',
    position: '',
    department: '',
    salary: 0,
    joinDate: '',
    status: 'active'
  }
  dialogVisible.value = true
}

const editEmployee = (employee) => {
  isEditing.value = true
  currentEmployee.value = { ...employee }
  dialogVisible.value = true
}

const saveEmployee = async () => {
  if (!employeeForm.value) return

  try {
    await employeeForm.value.validate()
    saveLoading.value = true

    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000))

    if (isEditing.value) {
      const index = employees.value.findIndex(emp => emp.id === currentEmployee.value.id)
      if (index !== -1) {
        employees.value[index] = { ...currentEmployee.value }
        ElNotification({
          title: 'Berhasil',
          message: 'Data karyawan berhasil diupdate',
          type: 'success'
        })
      }
    } else {
      const newEmployee = {
        ...currentEmployee.value,
        id: Date.now(),
        avatar: `https://i.pravatar.cc/150?img=${employees.value.length + 1}`
      }
      employees.value.push(newEmployee)
      ElNotification({
        title: 'Berhasil',
        message: 'Karyawan baru berhasil ditambahkan',
        type: 'success'
      })
    }

    dialogVisible.value = false
    saveLoading.value = false
  } catch (error) {
    saveLoading.value = false
    ElMessage.error('Mohon lengkapi semua field yang required')
  }
}

const deleteEmployee = (employee) => {
  ElMessageBox.confirm(
    `Apakah Anda yakin ingin menghapus ${employee.name}?`,
    'Konfirmasi Hapus',
    {
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
      type: 'warning'
    }
  ).then(() => {
    const index = employees.value.findIndex(emp => emp.id === employee.id)
    if (index !== -1) {
      employees.value.splice(index, 1)
      ElNotification({
        title: 'Berhasil',
        message: `${employee.name} berhasil dihapus`,
        type: 'success'
      })
    }
  }).catch(() => {
    ElMessage.info('Penghapusan dibatalkan')
  })
}

const updateStatus = async (employee) => {
  employee.statusLoading = true
  
  // Simulate API call
  await new Promise(resolve => setTimeout(resolve, 500))
  
  employee.statusLoading = false
  ElMessage.success(`Status ${employee.name} berhasil diubah`)
}

const handleSelectionChange = (selection) => {
  selectedEmployees.value = selection
}

const handleBulkAction = (command) => {
  if (command === 'export') {
    exportData()
  } else if (command === 'delete') {
    bulkDelete()
  }
}

const exportData = () => {
  const csvContent = generateCSV(filteredEmployees.value)
  downloadCSV(csvContent, 'data-karyawan.csv')
  ElMessage.success('Data berhasil diexport')
}

const bulkDelete = () => {
  if (selectedEmployees.value.length === 0) {
    ElMessage.warning('Pilih karyawan yang ingin dihapus')
    return
  }

  ElMessageBox.confirm(
    `Apakah Anda yakin ingin menghapus ${selectedEmployees.value.length} karyawan?`,
    'Konfirmasi Hapus Massal',
    {
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
      type: 'warning'
    }
  ).then(() => {
    const idsToDelete = selectedEmployees.value.map(emp => emp.id)
    employees.value = employees.value.filter(emp => !idsToDelete.includes(emp.id))
    ElNotification({
      title: 'Berhasil',
      message: `${selectedEmployees.value.length} karyawan berhasil dihapus`,
      type: 'success'
    })
    selectedEmployees.value = []
  })
}

const clearFilters = () => {
  filters.department = ''
  filters.status = ''
  filters.dateRange = null
  searchQuery.value = ''
  ElMessage.success('Filter berhasil direset')
}

const handleClose = (done) => {
  if (saveLoading.value) {
    ElMessage.warning('Sedang menyimpan data, mohon tunggu...')
    return
  }
  done()
}

const handleSizeChange = (size) => {
  pageSize.value = size
  currentPage.value = 1
}

const handleCurrentChange = (page) => {
  currentPage.value = page
}

const tableRowClassName = ({ rowIndex }) => {
  return rowIndex % 2 === 0 ? 'even-row' : 'odd-row'
}

const getDepartmentTagType = (department) => {
  const types = {
    'IT': 'primary',
    'HR': 'success',
    'Finance': 'warning',
    'Marketing': 'danger',
    'Operations': 'info',
    'Sales': ''
  }
  return types[department] || ''
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(amount)
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const generateCSV = (data) => {
  const headers = ['Nama', 'Email', 'Posisi', 'Departemen', 'Gaji', 'Tanggal Masuk', 'Status']
  const csvData = [headers.join(',')]
  
  data.forEach(emp => {
    const row = [
      emp.name,
      emp.email,
      emp.position,
      emp.department,
      emp.salary,
      emp.joinDate,
      emp.status
    ]
    csvData.push(row.join(','))
  })
  
  return csvData.join('\n')
}

const downloadCSV = (content, filename) => {
  const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' })
  const link = document.createElement('a')
  const url = URL.createObjectURL(blob)
  link.setAttribute('href', url)
  link.setAttribute('download', filename)
  link.style.visibility = 'hidden'
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}

// Lifecycle
onMounted(() => {
  initializeData()
  loading.value = false
})
</script>

<style scoped>
.crud-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 20px;
}

.header-section {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  border-radius: 20px 20px 0 0;
  padding: 40px;
  color: white;
  margin-bottom: 0;
  position: relative;
  overflow: hidden;
}

.header-section::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

.header-content {
  text-align: center;
  position: relative;
  z-index: 2;
}

.main-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.title-icon {
  font-size: 2.5rem;
}

.subtitle {
  font-size: 1.1rem;
  margin: 10px 0 0 0;
  opacity: 0.9;
}

.header-stats {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin-top: 30px;
  position: relative;
  z-index: 2;
}

.stat-card {
  background: rgba(255,255,255,0.2);
  backdrop-filter: blur(10px);
  border-radius: 15px;
  padding: 20px;
  text-align: center;
  min-width: 120px;
  border: 1px solid rgba(255,255,255,0.3);
}

.stat-number {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 0.9rem;
  opacity: 0.9;
}

.controls-section {
  background: white;
  padding: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.search-section {
  flex: 1;
  max-width: 400px;
}

.search-input {
  border-radius: 25px;
}

.search-input :deep(.el-input__inner) {
  border-radius: 25px;
  border: 2px solid #e4e7ed;
  transition: all 0.3s ease;
}

.search-input :deep(.el-input__inner:focus) {
  border-color: #409eff;
  box-shadow: 0 0 10px rgba(64, 158, 255, 0.3);
}

.action-buttons {
  display: flex;
  gap: 15px;
}

.add-btn {
  border-radius: 25px;
  padding: 12px 25px;
  font-weight: 600;
  box-shadow: 0 4px 15px rgba(64, 158, 255, 0.3);
  transition: all 0.3s ease;
}

.add-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(64, 158, 255, 0.4);
}

.filters-section {
  background: white;
  padding: 20px 30px;
  border-top: 1px solid #f0f0f0;
}

.table-section {
  background: white;
  padding: 0 30px 30px;
  border-radius: 0 0 20px 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.main-table {
  margin-bottom: 20px;
}

.main-table :deep(.el-table__header) {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.main-table :deep(.el-table__header th) {
  background: transparent;
  color: #495057;
  font-weight: 600;
  border-bottom: 2px solid #dee2e6;
}

.main-table :deep(.even-row) {
  background-color: #f8f9ff;
}

.main-table :deep(.odd-row) {
  background-color: white;
}

.main-table :deep(.el-table__row:hover) {
  background-color: #e3f2fd !important;
  transform: scale(1.01);
  transition: all 0.3s ease;
}

.employee-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.employee-avatar {
  border: 2px solid #e4e7ed;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.employee-details {
  display: flex;
  flex-direction: column;
}

.employee-name {
  font-weight: 600;
  color: #303133;
  margin-bottom: 2px;
}

.employee-position {
  font-size: 0.85rem;
  color: #909399;
}

.salary-text {
  font-weight: 600;
  color: #67c23a;
}

.action-buttons-cell {
  display: flex;
  gap: 8px;
  justify-content: center;
}

.action-buttons-cell .el-button {
  transition: all 0.3s ease;
}

.action-buttons-cell .el-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.pagination-section {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid #f0f0f0;
}

.employee-dialog :deep(.el-dialog__header) {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  color: white;
  padding: 20px 30px;
  margin: 0;
  border-radius: 8px 8px 0 0;
}

.employee-dialog :deep(.el-dialog__title) {
  color: white;
  font-weight: 600;
  font-size: 1.2rem;
}

.employee-dialog :deep(.el-dialog__close) {
  color: white;
}

.employee-dialog :deep(.el-dialog__body) {
  padding: 30px;
}

.employee-dialog :deep(.el-form-item__label) {
  font-weight: 600;
  color: #303133;
}

.dialog-footer {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding: 20px 30px;
  background: #f8f9fa;
  margin: 0 -30px -30px;
  border-radius: 0 0 8px 8px;
}

.dialog-footer .el-button {
  padding: 12px 25px;
  border-radius: 25px;
  font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
  .crud-container {
    padding: 10px;
  }
  
  .header-section {
    padding: 20px;
    border-radius: 15px 15px 0 0;
  }
  
  .main-title {
    font-size: 1.8rem;
    flex-direction: column;
    gap: 10px;
  }
  
  .header-stats {
    flex-direction: column;
    gap: 15px;
    align-items: center;
  }
  
  .stat-card {
    min-width: 100px;
  }
  
  .controls-section {
    flex-direction: column;
    align-items: stretch;
    gap: 15px;
    padding: 20px;
  }
  
  .search-section {
    max-width: none;
  }
  
  .action-buttons {
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .table-section {
    padding: 0 15px 20px;
  }
  
  .main-table :deep(.el-table__body-wrapper) {
    overflow-x: auto;
  }
  
  .employee-dialog {
    width: 95% !important;
    margin: 0 auto;
  }
}

/* Custom Scrollbar */
:deep(.el-table__body-wrapper::-webkit-scrollbar) {
  height: 8px;
}

:deep(.el-table__body-wrapper::-webkit-scrollbar-track) {
  background: #f1f1f1;
  border-radius: 4px;
}

:deep(.el-table__body-wrapper::-webkit-scrollbar-thumb) {
  background: #c1c1c1;
  border-radius: 4px;
}

:deep(.el-table__body-wrapper::-webkit-scrollbar-thumb:hover) {
  background: #a8a8a8;
}

/* Loading Animation */
.main-table :deep(.el-loading-mask) {
  background-color: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(5px);
}

/* Form Animations */
.employee-dialog :deep(.el-form-item) {
  margin-bottom: 20px;
  transition: all 0.3s ease;
}

.employee-dialog :deep(.el-input__inner:focus),
.employee-dialog :deep(.el-textarea__inner:focus) {
  border-color: #4facfe;
  box-shadow: 0 0 10px rgba(79, 172, 254, 0.3);
}

/* Tag Animations */
.main-table :deep(.el-tag) {
  transition: all 0.3s ease;
  cursor: default;
}

.main-table :deep(.el-tag:hover) {
  transform: scale(1.05);
}

/* Switch Styling */
.main-table :deep(.el-switch) {
  transition: all 0.3s ease;
}

.main-table :deep(.el-switch:hover) {
  transform: scale(1.1);
}

/* Button Hover Effects */
.bulk-dropdown :deep(.el-button:hover) {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Pagination Styling */
.pagination-section :deep(.el-pagination) {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.pagination-section :deep(.el-pager li:hover) {
  color: #4facfe;
  transform: scale(1.1);
}

.pagination-section :deep(.el-pager li.is-active) {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  color: white;
  border-radius: 50%;
}

/* Notification Customization */
:deep(.el-notification) {
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  backdrop-filter: blur(10px);
}

/* Message Box Customization */
:deep(.el-message-box) {
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

:deep(.el-message-box__header) {
  padding: 20px 30px 10px;
}

:deep(.el-message-box__content) {
  padding: 10px 30px 20px;
}

:deep(.el-message-box__btns) {
  padding: 10px 30px 20px;
}

/* Table Row Hover Animation */
@keyframes rowHighlight {
  0% { background-color: transparent; }
  50% { background-color: #e3f2fd; }
  100% { background-color: #e3f2fd; }
}

.main-table :deep(.el-table__row:hover td) {
  animation: rowHighlight 0.3s ease;
}

/* Loading Spinner Customization */
:deep(.el-loading-spinner) {
  margin-top: -25px;
}

:deep(.el-loading-spinner .circular) {
  width: 50px;
  height: 50px;
}

/* Form Input Focus Effects */
.employee-dialog :deep(.el-input__inner),
.employee-dialog :deep(.el-select .el-input__inner),
.employee-dialog :deep(.el-date-editor .el-input__inner) {
  transition: all 0.3s ease;
  border-radius: 8px;
}

.employee-dialog :deep(.el-input__inner:focus),
.employee-dialog :deep(.el-select:hover .el-input__inner),
.employee-dialog :deep(.el-date-editor:hover .el-input__inner) {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(79, 172, 254, 0.2);
}

/* Success Animation */
@keyframes successPulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

.el-button--primary:active {
  animation: successPulse 0.3s ease;
}

/* Table Header Gradient */
.main-table :deep(.el-table__header-wrapper) {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 8px 8px 0 0;
}

/* Custom Selection Style */
.main-table :deep(.el-table__row.current-row) {
  background-color: #f0f9ff;
  border-left: 4px solid #4facfe;
}

/* Tooltip Customization */
:deep(.el-tooltip__popper) {
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>